const assert = require('node:assert/strict');
const { readFileSync } = require('node:fs');
const { test } = require('node:test');
const { runInNewContext } = require('node:vm');

const source = readFileSync(require('node:path').join(__dirname, '../../public/js/show.js'), 'utf8');

function setup(lyrics = 'First line@Second line#Last verse', options = {}) {
    const listeners = new Map();
    const timers = new Map();
    let timerId = 0;
    function element() {
        const classes = new Set();
        return {
            hidden: false, disabled: false, textContent: '', dataset: {}, attributes: {}, children: [],
            clientHeight: 500, scrollHeight: 40, clientWidth: 800, scrollWidth: 800, offsetWidth: 800, offsetHeight: 96,
            classList: { add: value => classes.add(value), remove: value => classes.delete(value), contains: value => classes.has(value) },
            style: { removeProperty(name) { if (name === 'font-size') delete this.fontSize; } },
            setAttribute(name, value) { this.attributes[name] = value; },
            addEventListener(name, handler) { this[name] = handler; },
            replaceChildren(fragment) { this.children = fragment.children; },
            querySelector() { return this.icon; },
        };
    }
    const ids = Object.fromEntries(['lyric-data', 'visibletext', 'pageInfo', 'previous-slide', 'next-slide', 'fullscreen-toggle', 'imageDiv', 'presenter-status'].map(id => [id, element()]));
    ids['lyric-data'].textContent = JSON.stringify(lyrics);
    ids['fullscreen-toggle'].icon = {};
    const body = element();
    const stage = element();
    stage.clientHeight = options.stageHeight || 500;
    const content = element();
    if (options.lineCount) {
        Object.defineProperty(ids.visibletext, 'scrollHeight', {
            get() { return options.lineCount * parseFloat(this.style.fontSize || 44); },
        });
    }
    const doc = {
        body, fullscreenElement: null,
        getElementById: id => ids[id], querySelector: selector => selector === '.presenter-content' ? content : stage,
        addEventListener(name, handler) { listeners.set(name, handler); },
        createDocumentFragment: () => ({ children: [], appendChild(child) { this.children.push(child); } }),
        createTextNode: text => ({ text }), createElement: tag => ({ tag }),
    };
    const fire = (name, event = {}) => listeners.get(name)?.(event);
    doc.documentElement = {};
    if (!options.unsupported) {
        doc.documentElement.requestFullscreen = async () => {
            if (options.rejectFullscreen) throw new Error('Unavailable');
            doc.fullscreenElement = doc.documentElement;
            fire('fullscreenchange');
        };
    }
    doc.exitFullscreen = async () => { doc.fullscreenElement = null; fire('fullscreenchange'); };
    runInNewContext(source, {
        document: doc, window: { addEventListener() {} },
        sessionStorage: { getItem() { if (options.blockStorage) throw new Error('Blocked'); return null; } },
        getComputedStyle: () => ({ fontSize: '44px', paddingTop: '40px', paddingBottom: '40px', rowGap: '20px' }),
        setTimeout(callback, delay) { const id = ++timerId; timers.set(id, { callback, delay }); return id; },
        clearTimeout: id => timers.delete(id), requestAnimationFrame: callback => callback(), cancelAnimationFrame() {},
    });
    fire('DOMContentLoaded');
    const key = key => fire('keydown', { key, target: { tagName: 'BODY' }, preventDefault() {} });
    return { ids, body, doc, timers, fire, key };
}

test('shows the closing logo beneath the last lyric verse without adding a slide', () => {
    const { ids, key } = setup();
    assert.equal(ids.pageInfo.textContent, '1 / 2');
    assert.equal(ids['previous-slide'].disabled, true);
    assert.equal(ids.imageDiv.hidden, true);
    assert.deepEqual(ids.visibletext.children, [{ text: 'First line' }, { tag: 'br' }, { text: 'Second line' }]);
    key('ArrowRight');
    assert.equal(ids.visibletext.children[0].text, 'Last verse');
    assert.equal(ids.visibletext.hidden, false);
    assert.equal(ids.imageDiv.hidden, false);
    assert.equal(ids.pageInfo.textContent, '2 / 2');
    key('ArrowRight');
    assert.equal(ids.pageInfo.textContent, '2 / 2');
    assert.equal(ids.visibletext.children[0].text, 'Last verse');
    assert.equal(ids['next-slide'].disabled, true);
    key('ArrowLeft');
    assert.equal(ids.imageDiv.hidden, true);
    assert.equal(ids.visibletext.children[0].text, 'First line');
});

test('keyboard navigation stays in bounds and supports first and final slides', () => {
    const { ids, key } = setup();
    key('ArrowLeft');
    assert.equal(ids.pageInfo.textContent, '1 / 2');
    key('End'); key('PageDown');
    assert.equal(ids.pageInfo.textContent, '2 / 2');
    key('PageUp');
    assert.equal(ids.pageInfo.textContent, '1 / 2');
    key('Home');
    assert.equal(ids.pageInfo.textContent, '1 / 2');
});

test('a single lyric slide includes the logo and ignores trailing empty slides', () => {
    const { ids } = setup('Only verse# #');
    assert.equal(ids.pageInfo.textContent, '1 / 1');
    assert.equal(ids.visibletext.children[0].text, 'Only verse');
    assert.equal(ids.imageDiv.hidden, false);
    assert.equal(ids['previous-slide'].disabled, true);
    assert.equal(ids['next-slide'].disabled, true);
});

test('final-slide text fitting reserves room for the logo and its spacing', () => {
    const { ids, key } = setup(undefined, { stageHeight: 300, lineCount: 3 });
    assert.equal(ids.visibletext.style.fontSize, undefined);
    key('End');
    assert.equal(ids.visibletext.style.fontSize, '34px');
    key('Home');
    assert.equal(ids.visibletext.style.fontSize, undefined);
});

test('lyric markup is rendered literally, without HTML execution', () => {
    const { ids } = setup('<script>alert("unsafe")</script>@Words@@');
    assert.equal(ids.visibletext.children[0].text, '<script>alert("unsafe")</script>');
    assert.equal(ids.visibletext.children.length, 3);
});

test('ordinary presentation mode never starts an inactivity timer', () => {
    const { timers, body, fire } = setup();
    fire('pointermove');
    assert.equal(timers.size, 0);
    assert.equal(body.classList.contains('is-idle'), false);
});

test('fullscreen hides controls after 2000ms and mouse movement restores them', async () => {
    const { ids, timers, body, fire } = setup();
    await ids['fullscreen-toggle'].click();
    assert.equal(ids['fullscreen-toggle'].attributes['aria-label'], 'Exit fullscreen');
    const timer = [...timers.values()][0];
    assert.equal(timer.delay, 2000);
    timer.callback();
    assert.equal(body.classList.contains('is-idle'), true);
    fire('pointermove');
    assert.equal(body.classList.contains('is-idle'), false);
    assert.equal(timers.size, 1);
    await ids['fullscreen-toggle'].click();
    assert.equal(timers.size, 0);
    assert.equal(body.classList.contains('is-idle'), false);
    assert.equal(ids['fullscreen-toggle'].attributes['aria-label'], 'Enter fullscreen');
});

test('unsupported fullscreen remains usable with a clear status message', async () => {
    const { ids } = setup('Words', { unsupported: true });
    await ids['fullscreen-toggle'].click();
    assert.equal(ids['presenter-status'].hidden, false);
    assert.equal(ids['presenter-status'].textContent, 'Fullscreen is not available in this browser.');
});

test('rejected fullscreen requests are handled without unhandled errors', async () => {
    const { ids } = setup('Words', { rejectFullscreen: true });
    await ids['fullscreen-toggle'].click();
    assert.equal(ids['presenter-status'].hidden, false);
    assert.match(ids['presenter-status'].textContent, /could not be opened/);
});

test('empty lyrics and inaccessible browser storage do not break presentation', () => {
    const { ids, body } = setup(' # ', { blockStorage: true });
    assert.equal(ids.pageInfo.textContent, '1 / 1');
    assert.equal(ids.imageDiv.hidden, false);
    assert.equal(body.dataset.presentationTheme, 'immersive');
});

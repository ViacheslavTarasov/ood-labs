export let AddHarmonicResultView = class AddHarmonicResultView {
    constructor(el, controller, model) {
        this._el = el;
        this._controller = controller;
        this._model = model;
    }

    resetModel(model) {
        this._model = model;
    }

    render() {
        this._el.innerHTML = '<span>' +
            this._model.amplitude + ' * ' + this._model.func + '(' + this._model.frequency + ' * x + ' + this._model.phase + ')' +
            '</span>';
    }
};
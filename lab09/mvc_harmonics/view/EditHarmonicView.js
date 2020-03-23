import {DataTransformer} from "../model/DataTrasformer.js";

export let EditHarmonicView = class EditHarmonicView {
    constructor(el, controller, model) {
        this._el = el;
        this._controller = controller;
        this._model = model;

        this._model.onSelectedIndexChanched(function () {
            this.render();
        }.bind(this));
    }

    render() {
        let harmonic = this._model.getAtIndex(this._model.selectedIndex);
        let data = harmonic ? DataTransformer.createDtoFromHarmonic(this._model.getAtIndex(this._model.selectedIndex)) : undefined;
        this._el.innerHTML = template(data);
        this._initListeners();
    }

    _changeAmplitude(event) {
        this._controller.changeAmplitude(event.target.value);
    }

    _changeFunc(event) {
        this._controller.changeFunc(event.target.value);
    }

    _changeFrequency(event) {
        this._controller.changeFrequency(event.target.value);
    }

    _changePhase(event) {
        this._controller.changePhase(event.target.value);
    }

    _initListeners() {
        this._el.querySelector('input[name="harmonic-amplitude"]').addEventListener('keyup', this._changeAmplitude.bind(this));
        this._el.querySelectorAll('input[name="harmonic-func"]').forEach(function (elem) {
            elem.addEventListener('click', this._changeFunc.bind(this));
        }.bind(this));
        this._el.querySelector('input[name="harmonic-frequency"]').addEventListener('keyup', this._changeFrequency.bind(this));
        this._el.querySelector('input[name="harmonic-phase"]').addEventListener('keyup', this._changePhase.bind(this));
    }
};

let template = function (data) {
    let disabled = data ? '' : 'disabled';
    return `
        <label class="col-form-label">Amplitude</label>
        <input type="text" class="form-control" name="harmonic-amplitude" value="${data ? data.amplitude : ''}" ${disabled}>
        
        <div class="form-check form-check-inline pt-3">
            <input class="form-check-input" type="radio" name="harmonic-func" value="sin" ${!data || data.func === 'sin' ? 'checked' : ''} ${disabled}>
            <label class="form-check-label" >sin</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="harmonic-func" value="cos" ${data && data.func === 'cos' ? 'checked' : ''} ${disabled}>
            <label class="form-check-label">cos</label>
        </div>
        
        <div>
            <label class="col-form-label">Frequency</label>
            <input type="text" class="form-control" name="harmonic-frequency" value="${data ? data.frequency : ''}" ${disabled}>
        </div>
        <div>
            <label class="col-form-label">Phase</label>
            <input type="text" class="form-control" name="harmonic-phase"value="${data ? data.phase : ''}" ${disabled}>
        </div>
    `;
};
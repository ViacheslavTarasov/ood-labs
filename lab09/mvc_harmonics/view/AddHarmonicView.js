import {AddHarmonicResultView} from "./AddHarmonicResultView.js";
import {HarmonicDto} from "../model/HarmonicDto.js";

export let AddHarmonicView = class AddHarmonicView {
    constructor(el, controller, harmonic) {
        this._el = el;
        this._controller = controller;
        this._harmonic = harmonic;
    }

    _save() {
        this._controller.save(this._harmonic);
        $(this._el).modal('hide');
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

    _initResultView() {
        this._resultView = new AddHarmonicResultView(
            this._el.querySelector('.add-harmonic-result'),
            this._controller,
            this._harmonic
        );
        this._harmonic.onUpdated(function () {
                this._resultView.render();
            }.bind(this)
        );
    }

    _initListeners() {
        this._el.querySelector('input[name="harmonic-amplitude"]').addEventListener('keyup', this._changeAmplitude.bind(this));
        this._el.querySelectorAll('input[name="harmonic-func"]').forEach(function (elem) {
            elem.addEventListener('click', this._changeFunc.bind(this));
        }.bind(this));
        this._el.querySelector('input[name="harmonic-frequency"]').addEventListener('keyup', this._changeFrequency.bind(this));
        this._el.querySelector('input[name="harmonic-phase"]').addEventListener('keyup', this._changePhase.bind(this));
        this._el.querySelector('#save-new-harmonic').addEventListener('click', this._save.bind(this));

        this._initResultView();
    }

    resetModel(harmonic) {
        this._harmonic = harmonic;
        this._resultView.resetModel(harmonic);
    }

    render() {
        let data = HarmonicDto.fromModel(this._harmonic);

        this._el.innerHTML = template(data);
        this._initListeners();
        this._resultView.render();
        $(this._el).modal();
    }
};

let template = function (data) {
    return `
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New harmonic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="add-harmonic-form">
                    <label class="col-form-label">Amplitude</label>
                    <input type="text" class="form-control" name="harmonic-amplitude" id="amplitude" value="${data.amplitude}">
                    
                    <div class="form-check form-check-inline pt-3">
                        <input class="form-check-input" type="radio" name="harmonic-func" value="sin" ${data.func === 'sin' ? 'checked' : ''}>
                        <label class="form-check-label" >sin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="harmonic-func" value="cos" ${data.func === 'cos' ? 'checked' : ''}>
                        <label class="form-check-label">cos</label>
                    </div>
                    
                    <div>
                        <label class="col-form-label">Frequency</label>
                        <input type="text" class="form-control" name="harmonic-frequency" value="${data.frequency}">
                    </div>
                    <div>
                        <label class="col-form-label">Phase</label>
                        <input type="text" class="form-control" name="harmonic-phase"value="${data.phase}">
                    </div>
                </div>
                <hr>
                <div class="add-harmonic-result"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save-new-harmonic">Save</button>
            </div>
        </div>
    </div> 
    `;
};
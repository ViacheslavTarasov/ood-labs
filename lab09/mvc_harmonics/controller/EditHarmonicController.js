import {EditHarmonicView} from "../view/EditHarmonicView.js";
import {EventEmitter} from "../EventEmitter.js";

export let EditHarmonicController = class EditHarmonicController extends EventEmitter {
    constructor(model) {
        super();

        this._model = model;
        this._view = new EditHarmonicView(document.querySelector('#edit-harmonic'), this, this._model);
    };

    changeAmplitude(value) {
        this._getHarmonic().amplitude = value;
    }

    changeFunc(value) {
        this._getHarmonic().func = value;
    }

    changeFrequency(value) {
        this._getHarmonic().frequency = value;
    }

    changePhase(value) {
        this._getHarmonic().phase = value;
    }

    showEditForm() {
        this._view.render();
    }

    _getHarmonic() {
        return this._model.getAtIndex(this._model.selectedIndex);
    }
};
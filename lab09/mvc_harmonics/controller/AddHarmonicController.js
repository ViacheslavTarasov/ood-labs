import {AddHarmonicView} from "../view/AddHarmonicView.js";
import {EventEmitter} from "../EventEmitter.js";
import {HarmonicEvents} from "../model/HarmonicEvents.js";

export let AddHarmonicController = class AddHarmonicController extends EventEmitter {
    constructor(harmonic) {
        super();

        this._harmonic = harmonic;
        this._view = new AddHarmonicView(document.querySelector('#new-harmonic-modal'), this, this._harmonic);
    };

    changeAmplitude(value) {
        this._harmonic.amplitude = value;
    }

    changeFunc(value) {
        this._harmonic.func = value;
    }

    changeFrequency(value) {
        this._harmonic.frequency = value;
    }

    changePhase(value) {
        this._harmonic.phase = value;
    }

    showAddForm() {
        this._view.render();
    }

    save() {
        this.emit(HarmonicEvents.ADD_TRIED, this._harmonic);
    }

    onSave(handler) {
        this.on(HarmonicEvents.ADD_TRIED, handler)
    }

    resetModel(harmonic) {
        this._harmonic = harmonic;
        this._view.resetModel(this._harmonic);
    }
};
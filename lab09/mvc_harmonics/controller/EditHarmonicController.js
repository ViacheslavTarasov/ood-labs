import {EditHarmonicView} from "../view/EditHarmonicView.js";
import {EventEmitter} from "../EventEmitter.js";

export let EditHarmonicController = class EditHarmonicController extends EventEmitter {
    constructor(model) {
        super();

        this._model = model;
        this._view = new EditHarmonicView(document.querySelector('#edit-harmonic'), this, this._model);
    };

    changeAmplitude(value) {
        let item = this._getSelected();
        item.amplitude = value;
        this._updateSelected(item);
    }

    changeFunc(value) {
        let item = this._getSelected();
        item.func = value;
        this._updateSelected(item);
    }

    changeFrequency(value) {
        let item = this._getSelected();
        item.frequency = value;
        this._updateSelected(item);
    }

    changePhase(value) {
        let item = this._getSelected();
        item.phase = value;
        this._updateSelected(item);
    }

    showEditForm() {
        this._view.render();
    }

    resetModel(model) {
        this._model = model;
        this._view.resetModel(this._model)
    }

    _initEventListeners() {

    }

    _getSelected() {
        return this._model.getAtIndex(this._model.selectedIndex);
    }

    _updateSelected(harmonicDto) {
        this._model.updateItemAt(this._model.selectedIndex, harmonicDto)
    }
};
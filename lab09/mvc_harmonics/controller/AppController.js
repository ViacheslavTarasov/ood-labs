import {AppView} from "../view/AppView.js";
import {Harmonic} from "../model/Harmonic.js";
import {AddHarmonicController} from "./AddHarmonicController.js";
import {EditHarmonicController} from "./EditHarmonicController.js";
import {DataTransformer} from "../model/DataTrasformer.js";
import {ChartController} from "./ChartController.js";

export let AppController = class AppController {
    constructor(harmonicList) {
        this._harmonicList = harmonicList;
        this._view = new AppView(document.querySelector('body'), this, this._harmonicList);
        this._addController = new AddHarmonicController(this.createNewHarmonic());
        this._editController = new EditHarmonicController(this._harmonicList);

        this._addController.onSave(
            function (harmonic) {
                this._harmonicList.addItem(DataTransformer.createDtoFromHarmonic(harmonic));
                this._addController.resetModel(this.createNewHarmonic());
            }.bind(this)
        );

        this._view.render();
    }

    deleteSelected() {
        let index = this._harmonicList.selectedIndex;
        if (index !== -1) {
            this._harmonicList.removeItemAt(index);
            this._harmonicList.selectedIndex = -1;
        }
    }

    changeAmplitude(value) {
        if (this._harmonicList.selectedIndex !== -1) {
            this._harmonicList.updateItemAt(this._harmonicList.selectedIndex,)
            this._harmonicList.getAtIndex(this._harmonicList.selectedIndex).amplitude = value;
        }
    }

    selectItem(index) {
        if (this._harmonicList.getAtIndex(index) === undefined || this._harmonicList.selectedIndex === index) {
            return;
        }
        this._harmonicList.selectedIndex = index;
        // let harmonic = DataTransformer.createHarmonicFromDto(this._harmonicList.getAtIndex(index));
        // this._editController.resetModel(harmonic);
    }

    createNewHarmonic() {
        return new Harmonic();
    }

    getSelectedHarmonic() {
        this._harmonicList.getAtIndex(this._harmonicList.selectedIndex)
    }

    showAddForm() {
        this._addController.showAddForm();
    }

    showEditForm() {
        this._editController.showEditForm();
    }

    createChartController() {
        return new ChartController(this._harmonicList);
    }
};
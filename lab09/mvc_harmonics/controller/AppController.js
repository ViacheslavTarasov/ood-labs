import {AppView} from "../view/AppView.js";
import {Harmonic} from "../model/Harmonic.js";
import {AddHarmonicController} from "./AddHarmonicController.js";
import {EditHarmonicController} from "./EditHarmonicController.js";
import {HarmonicDto} from "../model/HarmonicDto.js";

export let AppController = class AppController {
    constructor(harmonicList) {
        this._harmonicList = harmonicList;
        this._view = new AppView(document.querySelector('body'), this, this._harmonicList);
        this._addController = new AddHarmonicController(this.createNewHarmonic());
        this._editController = new EditHarmonicController(this._harmonicList);

        this._addController.onSave(
            function (harmonic) {
                this._harmonicList.addItem(HarmonicDto.fromModel(harmonic));
                this._addController.resetModel(this.createNewHarmonic());
                console.log(this._harmonicList);
            }.bind(this)
        );

        this._view.render();
    }

    selectItem(index) {
        if (this._harmonicList.getAtIndex(index) === undefined || this._harmonicList.selectedIndex === index) {
            return;
        }
        this._harmonicList.selectedIndex = index;
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
};
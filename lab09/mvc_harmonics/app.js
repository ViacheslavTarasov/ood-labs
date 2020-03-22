import {HarmonicList} from "./model/HarmonicList.js";
import {AppController} from "./controller/AppController.js";
import {Harmonic} from "./model/Harmonic.js";


let app = {
    run() {

        this._harmonicList = new HarmonicList(
            [
                new Harmonic(),
                new Harmonic()
            ]
        );
        // this._currentHarmonic = null;
        // this._newHarmonic = null;
        //
        // this._harmonicListController = new

        this._controller = new AppController(this._harmonicList);
        this._controller.showAddForm();
        this._controller.showEditForm();
    }
};


app.run();
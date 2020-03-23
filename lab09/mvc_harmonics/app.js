import {HarmonicList} from "./model/HarmonicList.js";
import {AppController} from "./controller/AppController.js";
import {Harmonic} from "./model/Harmonic.js";
import {DataTransformer} from "./model/DataTrasformer.js";

let app = {
    run() {
        this._harmonicList = new HarmonicList([DataTransformer.createDtoFromHarmonic(new Harmonic())]);
        this._controller = new AppController(this._harmonicList);
        this._controller.showEditForm();
    }
};

app.run();
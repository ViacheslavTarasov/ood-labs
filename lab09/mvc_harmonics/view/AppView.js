import {ChartHarmonicView} from "./ChartHarmonicView.js";
import {TableHarmonicView} from "./TableHarmonicView.js";
import {HarmonicListView} from "./HarmonicListView.js";

export let AppView = class AppView {
    constructor(el, controller, model) {
        this._el = el;
        this._controller = controller;
        this._model = model;

        this._elements = {
            newBtn: this._el.querySelector('#add-new'),
            deleteBtn: this._el.querySelector('#delete-selected'),
            harmonicList: this._el.querySelector('#harmonics-list'),

            addHarmonic: this._el.querySelector('#new-harmonic-modal'),
            editHarmonic: this._el.querySelector('#edit-harmonic'),
            harmonicChart: this._el.querySelector('#harmonic-chart'),
            harmonicTable: this._el.querySelector('#harmonic-table'),
        };

        this._initChildViews();
        this._initEventListeners();
    }

    _onDeleteBtn() {
        this._controller.deleteSelected();
    }

    _initEventListeners() {
        this._elements.newBtn.addEventListener('click', this.showAddForm.bind(this));
        this._elements.deleteBtn.addEventListener('click', this._onDeleteBtn.bind(this));
    }


    showAddForm() {
        // this._views.addHarmonicView.render();
        this._controller.showAddForm();
    }

    _initChildViews() {
        this._views = {
            harmonicListView: new HarmonicListView(this._elements.harmonicList, this._controller, this._model),
            // addHarmonicView: new AddHarmonicView(this._elements.addHarmonic, this._controller, this._controller.createNewHarmonic()),
            // editHarmonicView: new EditHarmonicView(this._elements.editHarmonic, this._controller, this._controller.getSelectedHarmonic()),
            chartHarmonicView: new ChartHarmonicView(this._elements.harmonicChart, this._controller.createChartController(), this._model),
            tableHarmonicView: new TableHarmonicView(this._elements.harmonicTable, this._controller.createChartController(), this._model),
        }
    }

    render() {
        this._views.harmonicListView.render();
        this._views.chartHarmonicView.render();
        this._views.tableHarmonicView.render();
    }
};
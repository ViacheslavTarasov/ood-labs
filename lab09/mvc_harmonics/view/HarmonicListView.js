export let HarmonicListView = class HarmonicListView {
    constructor(el, controller, model) {
        this._el = el;
        this._controller = controller;
        this._model = model;

        this._model.onItemAdded(this._onListChanged());
        this._model.onItemUpdated(this._onListChanged());
        this._model.onItemRemoved(this._onListChanged());
    }

    _onListChanged() {
        return function () {
            this.render();
        }.bind(this)
    }

    _selectItem(event) {
        this._controller.selectItem(event.target.value);
    };

    render() {
        let html = '';
        let selectedIndex = this._model.selectedIndex;
        this._model.getItems().forEach(function (item, index) {
            let selected = index.toString() === selectedIndex.toString();
            html += `
                <option value="${index}" ${selected ? 'selected' : ''}>
                    ${item.amplitude} * ${item.func} (${item.frequency} + ${item.phase}) 
                </option>
            `;
        });

        this._el.innerHTML = html;

        this._el.addEventListener('change', this._selectItem.bind(this));
    }
};
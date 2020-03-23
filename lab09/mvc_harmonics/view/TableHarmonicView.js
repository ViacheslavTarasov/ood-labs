export let TableHarmonicView = class TableHarmonicView {
    constructor(el, controller, model) {
        this._el = el;
        this._controller = controller;
        this._model = model;

        this._model.onSelectedIndexChanched(function () {
            this.render();
        }.bind(this));

        this._model.onItemUpdated(function () {
            this.render();
        }.bind(this));
    }

    render() {
        let points = this._controller.getPoints();
        this._el.innerHTML = template(points);
    }
};

let template = function (data) {
    let tr = '';
    data.forEach(function (item) {
        tr += `
            <tr>
              <th scope="col">${item.x}</th>
              <th scope="col">${item.y}</th>
            </tr>        
        `;
    });
    return `
        <table class="table">
          <thead>
            <tr>
              <th scope="col">x</th>
              <th scope="col">y</th>
            </tr>
          </thead>
          <tbody>
            ${tr}
          </tbody>
        </table>
    `;
};
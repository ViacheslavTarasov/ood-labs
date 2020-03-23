const LEFT = -5;
const RIGHT = 5;

export let ChartController = class ChartController {
    constructor(model) {
        this._model = model;
    };

    getPoints() {
        let harmonic = this._model.getAtIndex(this._model.selectedIndex);
        let points = [];
        if (harmonic !== undefined) {
            for (let x = LEFT; x <= RIGHT; x = x + 0.05) {
                let funcArg = harmonic.frequency * x + parseFloat(harmonic.phase);
                let funcResult = harmonic.func === 'sin' ? Math.sin(funcArg) : Math.cos(funcArg);
                points.push({
                        x: x.toFixed(2),
                        y: (harmonic.amplitude * funcResult).toFixed(2)
                    }
                );
            }
        }
        return points;
    }
};
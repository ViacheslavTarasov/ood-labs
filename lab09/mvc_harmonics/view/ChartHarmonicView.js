const WIDTH = 800;
const HEIGHT = 400;
const MIN = -6;
const MAX = 6;
export let ChartHarmonicView = class ChartHarmonicView {
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

    _transX(x) {
        let x0 = Math.round(WIDTH / 2);
        let scale = WIDTH / (MAX - MIN);
        return Math.round(x0 + scale * x);
    }

    _transY(y) {
        let y0 = Math.round(HEIGHT / 2);
        let scale = HEIGHT / (MAX - MIN);
        return Math.round(y0 - scale * y);
    }

    _transPoint(point) {
        return {
            x: this._transX(point.x),
            y: this._transY(point.y)
        }
    }

    _drawAxis(ctx) {
        ctx.beginPath();
        ctx.lineWidth = 1;
        ctx.moveTo(0, HEIGHT / 2);
        ctx.lineTo(WIDTH, HEIGHT / 2);

        ctx.moveTo(WIDTH / 2, 0);
        ctx.lineTo(WIDTH / 2, HEIGHT);

        for (let i = MIN; i <= MAX; i++) {
            ctx.moveTo(this._transX(i), this._transY(-0.2));
            ctx.lineTo(this._transX(i), this._transY(0.2));
        }

        for (let i = MIN; i <= MAX; i++) {
            ctx.moveTo(this._transX(-0.1), this._transY(i));
            ctx.lineTo(this._transX(0.1), this._transY(i));
        }
        ctx.stroke();
    }

    _drawPoints(ctx, points) {
        let point = this._transPoint(points[0]);
        ctx.beginPath();
        ctx.lineWidth = 3;
        ctx.moveTo(point.x, point.y);
        for (let i = 1; i < points.length; i++) {
            point = this._transPoint(points[i]);
            console.log(point.x, point.y);
            ctx.lineTo(point.x, point.y);
            ctx.moveTo(point.x, point.y);
        }
        ctx.stroke();
    }

    render() {
        this._el.innerHTML = template();

        let points = this._controller.getPoints();
        let canvas = this._el.querySelector('canvas');
        if (!canvas.getContext) {
            alert('canvas unsupported');
            return;
        }

        canvas.width = WIDTH;
        canvas.height = HEIGHT;

        let ctx = canvas.getContext('2d');
        if (points.length) {
            this._drawAxis(ctx);
            this._drawPoints(ctx, points);
        }
    }
};

let template = function (data) {
    return '<canvas></canvas>';
};
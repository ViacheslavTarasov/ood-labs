import {EventEmitter} from "../EventEmitter.js";
import {HarmonicListEvents} from "./HarmonicListEvents.js";

export let HarmonicList = class HarmonicList extends EventEmitter {
    constructor(items) {
        super();
        this._items = items || [];
        this._selectedIndex = -1;
    }

    getItems() {
        return this._items.slice();
    }

    addItem(harmonicDto) {
        this._items.push(this._createHarmonic(harmonicDto));
        this.emit(HarmonicListEvents.ITEM_ADDED, this._items[this._items.length - 1]);
    }

    getAtIndex(index) {
        if (this._items[index] !== undefined) {
            return this._items[index];
        }
    }

    updateItemAt(index, harmonicDto) {
        if (this._items[index] !== undefined) {
            this._items[index] = this._createHarmonic(harmonicDto);
            this.emit(HarmonicListEvents.ITEM_UPDATED, index);
        }
    }

    removeItemAt(index) {
        const item = this._items.splice(index, 1);
        this.emit(HarmonicListEvents.ITEM_REMOVED, item);
        if (index === this._selectedIndex) {
            this.selectedIndex = -1;
        }
    }

    get selectedIndex() {
        return this._selectedIndex;
    }

    set selectedIndex(index) {
        const previousIndex = this._selectedIndex;
        this._selectedIndex = index;
        this.emit(HarmonicListEvents.SELECTED_INDEX_CHANGED, previousIndex);
    }

    onItemAdded(handler) {
        this.on(HarmonicListEvents.ITEM_ADDED, handler);
    }

    onItemUpdated(handler) {
        this.on(HarmonicListEvents.ITEM_UPDATED, handler);
    }

    onItemRemoved(handler) {
        this.on(HarmonicListEvents.ITEM_REMOVED, handler);
    }

    onSelectedIndexChanched(handler) {
        this.on(HarmonicListEvents.SELECTED_INDEX_CHANGED, handler);
    }

    _createHarmonic(item) {
        return {
            amplitude: item.amplitude,
            func: item.func,
            frequency: item.frequency,
            phase: item.phase
        }
    }
};
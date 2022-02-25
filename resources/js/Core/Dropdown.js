class Dropdown {
    isActive = false;
    items;

    constructor(data) {
        for (let property in data) this[property] = data[property];

        this.isActive = false;
        // this["activeItem"] = null;
        // this.setActiveItem();
        // console.log(this["activeItem"]);
    }

    activate() {
        this.isActive = true;
    }

    deactivate() {
        this.isActive = false;
    }

    use() {
        if (!this.isActive) this.activate();
        else this.deactivate();
    }

    onBlur() {
        setTimeout(() => this.deactivate(), 150);
    }

    setActiveItem(item = null) {
        if (item === null) {
            for (let i = 0; i < this['items'].length; i++) {
                let dropdownItem = this['items'][i];
                if (dropdownItem.isActive()) {
                    item = dropdownItem;

                    break;
                }
            }
        }

        this['activeItem'] = item;
    }

    findItemByText(text) {
        for (let itemIndex in this['items']) {
            let item = this['items'][itemIndex];
            if (item.text === text) return item;
        }

        return null;
    }
    getActiveItem() {
        return this['activeItem'];
    }

    selectCustomItem() {
        let text = 'custom';

        if (this.getActiveItem().text !== text) {
            let customItem = this.findItemByText(text);
            if (customItem) this.chooseNewItem(customItem);
        }
    }
    chooseNewItem(item) {
        let activeItem = this.getActiveItem();
        let newItem = false;
        if (activeItem !== item) {
            activeItem.deactivate();
            item.activate();
            this.setActiveItem();
            newItem = true;
        }

        this.deactivate();
        return newItem;
    }
}

export default Dropdown;

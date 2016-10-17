import Element from './element';

export default class Picture {
    constructor(data) {
        let self = this;
        this.elements = [];
        this.activeElement = new Element({});

        if (data.id) {
            this.id = data.id;
            this.name = data.name;
            this.width = data.width;
            this.height = data.height;
        }

        if (data.elements) {
            data.elements.forEach(function (elementData) {
                self.elements.push(new Element(elementData));
            });
        }
    }

    setActiveElement(element) {
        if(element instanceof Element) {
            this.activeElement = element;
        }
    }

    addElement() {
        this.elements.push(new Element({
            type: 'div',
            name: 'New element',
            styles: {
                width: 100,
                height: 100,
                backgroundColor: '#AAA'
            }
        }));
        console.log(this.elements);
    }

    getPostData() {
        let elements = [];
        this.elements.forEach(function (element) {
            elements.push(element.getPostData());
        });
        return {
            name: this.name,
            width: this.width,
            height: this.height,
            elements,
        };
    }
}
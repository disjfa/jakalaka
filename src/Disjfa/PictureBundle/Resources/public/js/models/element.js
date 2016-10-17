export default class Element {
    constructor(data) {
        this.id = data.id;
        this.name = data.name;
        this.type = data.type;
        this.styles = data.styles;

    }

    getPostData() {
        return {
            name: this.name,
            type: this.type,
            styles: this.styles
        }
    }

    updateStyles(styles) {
        for (var prop in styles) {
            this.styles[prop] = styles[prop];
        }
    }

    getStyles() {
        let data = {};
        for (var style in this.styles) {
            switch (style) {
                case 'blur':
                    data['filter'] = 'blur(' + this.styles[style] + 'px)';
                    break;
                case 'top':
                case 'left':
                case 'width':
                case 'height':
                    data[style] = this.styles[style] + 'px';
                    break;
                default:
                    data[style] = this.styles[style];
                    break;
            }
        }

        return data;
    }
}
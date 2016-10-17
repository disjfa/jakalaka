<template>
    <div class="picture-element" style="position:absolute;" :style="element.getStyles()" @click="setActiveElement()">
        {{ element.styles.width }}
    </div>
</template>
<script>
    export default{
        props: ['element', 'picture'],
        mounted () {
            var self = this;
            $(this.$el).draggable({
                stop: function (event, ui) {
                    self.element.updateStyles(ui.position);
                }
            });

            $(this.$el).resizable({
                stop: function (event, ui) {
                    self.element.updateStyles(ui.size);
                }
            });
        },
        methods: {
            setActiveElement() {
                this.picture.setActiveElement(this.element);
            }
        }
    }
</script>

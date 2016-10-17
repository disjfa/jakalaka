<template>
    <div class="picture-base" :style="{width: picture.width + 'px', height: picture.height + 'px'}">
        <picture-element v-for="element in picture.elements" :element="element" :picture="picture"></picture-element>
    </div>
</template>
<script>
    export default {
        props: ['picture'],
        components: {
            'picture-element': require('./picture-element.vue')
        },
        mounted () {
            $(this.$el).draggable();
            this.$on('setActiveElement', function(element) {
                console.log('b');
            });
        },
        methods: {
            setActiveElement(element) {
                console.log(element);
            }
        }
    }
</script>
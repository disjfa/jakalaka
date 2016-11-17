<style>
    .picture-main {
        padding: 20px;
    }

    .picture-base {
        background: green;
        position: relative;
    }

    .picture-element {
        position: absolute;
    }
</style>
<template>
    <div class="row">
        <div class="col-lg-9  bg-inverse">
            <div class="picture-main">
                <picture-base :picture="picture"></picture-base>
            </div>
        </div>
        <div class="col-lg-3">
            <div>
                <element-settings :element="picture.activeElement"></element-settings>
            </div>
            <a href="#" @click="save()" class="btn btn-primary">Save</a>
            <div class="list-group">
                <div v-for="element in picture.elements" class="list-group-item">
                    <input v-model="element.name" class="form-control">
                </div>
                <a href="#" @click="addElement()" class="list-group-item">Add element</a>
            </div>
        </div>
    </div>
</template>
<script>
    import Picture from './models/picture';
    import Vue from 'vue';

    export default {
        props: ['pictureId'],
        directives: {
            'draggable': require('./directives/draggable.vue')
        },
        components: {
            'picture-base': require('./components/picture-base.vue'),
            'element-settings': require('./components/element-settings.vue')
        },
        data () {
            return {
                picture: new Picture({}),
                pictureStore: require('./store')
            }
        },
        mounted () {
            this.initData();

            console.log(this.pictureStore);
        },
        methods: {
            save() {
                this
                        .$http
                        .patch(Routing.generate('disjfa_picture_api_picture_patch', {picture: this.pictureId}), this.picture.getPostData())
                        .then(function (result) {
                            Vue.set(this, 'picture', new Picture(result.data.picture));
                        });
            },
            initData() {
                this
                        .$http
                        .get(Routing.generate('disjfa_picture_api_picture_get', {picture: this.pictureId}))
                        .then(function (result) {
                            Vue.set(this, 'picture', new Picture(result.data.picture));
                        });
            },
            addElement () {
                this.picture.addElement();
            }
        }
    }
</script>
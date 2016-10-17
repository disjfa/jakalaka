<template>
    <div v-if="element.id">
        <div class="form-group">
            <label>Name</label>
            <input v-model="element.name" class="form-control" type="text">
        </div>
        <div class="form-group">
            <label>Color({{ element.styles.backgroundColor }})</label>
            <input v-model="element.styles.backgroundColor" class="form-control" type="color">
        </div>
        <div class="form-group">
            <label>Blur</label>
            <input v-model="element.styles.blur" class="form-control" type="number">
        </div>
        <div class="form-group">
            <label>Opacity</label>
            <input v-model="element.styles.opacity" class="form-control" type="number">
        </div>
        <div class="form-group">
            <label>Width</label>
            <input v-model="element.styles.width" class="form-control" type="number">
        </div>
        <div class="form-group">
            <label>Height</label>
            <input v-model="element.styles.height" class="form-control" type="number">
        </div>
    </div>
</template>
<script>
    export default{
        props: ['element']
    }
</script>

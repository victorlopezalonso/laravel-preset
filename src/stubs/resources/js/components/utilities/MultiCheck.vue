<template>

    <div class="multicheck">

        <div class="field" v-for="item in items">
            <label class="checkbox">
                <input type="checkbox" :checked="item.checked" @click="updateSelected(item)">
                {{item.value}}
            </label>
        </div>

    </div>

</template>

<script>
    export default {

        props: ['items'],

        methods: {

            updateSelected(item) {
                this.items.find((object, index) => {

                    if (object.key === item.key) {
                        this.items[index].checked = !this.items[index].checked;
                        return true;
                    }
                });
            }

        }

    }
</script>

<style>

    .multicheck {
        overflow-y: auto;
        max-height: 150px;
        background-color: white;
        border: solid 1px #dbdbdb;
        color: #363636;
        -webkit-box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
        box-shadow: inset 0 1px 2px rgba(10, 10, 10, 0.1);
        max-width: 100%;
        width: 100%;
        padding: 10px;
    }

</style>

<template>
    <div class="multiselect">
        <label>Selecciona opciones:</label>
        <select multiple v-model="selectedOptions" class="select-box">
            <option v-for="option in options" :key="option" :value="option">
                {{ option }}
            </option>
        </select>

        <div class="selected">
            <h4>Opciones seleccionadas:</h4>
            <ul>
                <li v-for="(item, index) in selectedOptions" :key="index">{{ item }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Multiselect',
    data() {
        return {
            options: ['Riña', 'Excibicionismo', 'Acoso', 'No trabajó', 'Retardo'],
            selectedOptions: []
        }
    }
}
</script>

<style scoped>
.multiselect {
    padding: 1rem;
    font-family: Arial;
}

.select-box {
    width: 300px;
    height: 100px;
    border-radius: 8px;
    padding: 0.5rem;
}

.selected ul {
    padding-left: 1rem;
}
</style>


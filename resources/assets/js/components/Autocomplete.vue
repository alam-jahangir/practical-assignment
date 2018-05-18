<template>
    <div style="position:relative" v-bind:class="{'open':openSuggestion}">
        <input class="form-control" type="text" placeholder="Select Category" :value="category.parent_name" @input="updateValue($event.target.value)"
               @keydown.enter = 'enter'
               @keydown.down = 'down'
               @keydown.up = 'up'
        >

        <input type="hidden" class="form-control" v-model="category.parent_id" />

        <ul class="dropdown-menu" style="width:100%">
            <li v-for="(suggestion, index) in matches"
                v-bind:class="{'active': isActive(index)}" v-if="suggestion.id != category.id"
                @click="suggestionClick(index)"
            >
                <a href="#">{{ suggestion.name }}</a>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                required: false
            },
            suggestions: {
                type: Array,
                required: false
            },
            category: {
                type: Object,
                required: true,
                default() {}
            }
        },
        data () {
            return {
                open: false,
                current: 0,
                //current_id:0,
                auto_suggestions: []
            }
        },
        computed: {
            // Filtering the suggestion based on the input
            matches () {
                return this.auto_suggestions;
            },
            openSuggestion () {
                return this.selection !== '' &&
                    this.matches.length !== 0 &&
                    this.open === true
            }
        },


        methods: {

            fetchSuggestionData(value) {

                if (value.length >= 2 ) {

                    fetch('api/autocomplete', {
                        method: 'post',
                        body: JSON.stringify({'name': value}),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        this.auto_suggestions = res.data;

                    })
                    .catch(err => console.log(err));

                } else {
                    this.auto_suggestions = [];
                }
            },

            updateValue (value) {
                this.category.parent_name = value;
                this.fetchSuggestionData(value);
                if (this.open === false) {
                    this.open = true
                    this.current = 0
                }

                //this.$emit('input', value);
            },
            // When enter pressed on the input
            enter () {
                this.$emit('input', this.matches[this.current].name)
                this.open = false
            },
            // When up pressed while suggestions are open
            up () {
                if (this.current > 0) {
                    this.current--
                }
            },
            // When up pressed while suggestions are open
            down () {
                if (this.current < this.matches.length - 1) {
                    this.current++
                }
            },
            // For highlighting element
            isActive (index) {
                return index === this.current
            },
            // When one of the suggestion is clicked
            suggestionClick (index) {
                this.category.parent_name = this.matches[index].name;
                //this.$emit('input', this.matches[index].name)
                this.category.parent_id = this.matches[index].id
                this.open = false;
            }
        }
    }
</script>
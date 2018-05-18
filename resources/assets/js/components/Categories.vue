<template>

    <div>

        <div v-if="action === 'add'">
            <h2>
                <span v-if="category.id">Edit "{{category.name}}"</span>
                <span v-else>Add New Category</span>
            </h2>
            <form @submit.prevent="addCategory" class="mb-3">

                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" placeholder="Name" v-model="category.name" />
                </div>

                <div class="form-group">
                    <label>Select Parent Category</label>
                    <autocomplete :suggestions="suggestions" :category="category" :selection="category.parent_name"></autocomplete>
                </div>

                <div class="col-xs-12 col-md-12">
                    <div class="col-xs-8 col-md-8">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-block mb-2">Save</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" @click="fetchCategories()" class="btn btn-primary btn-block">Back</button>
                    </div>
                </div>

            </form>
        </div>

        <div v-else-if="action === 'show'">
            <div class="card card-body" v-if="category" v-bind:key="category.id">
                <h3>{{category.name}}</h3>
                <p>{{category.parent_id}}</p>
                <hr />
                <button @click="editCategory(category)" class="btn btn-warning mb-2">Edit</button>
                <button @click="deleteCategory(category.id)" class="btn btn-danger">Delete</button>
            </div>
        </div>

        <div v-else="action === 'list'">
            <h2>Categories</h2>
            <div class="mb-2" v-if="action !== 'add'">
                <button @click="createCategory()" class="btn btn-success">Add New Category</button>
            </div>
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                        <a class="page-link" href="#" @click="fetchCategories(pagination.prev_page_url)">Previous</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link text-dark" href="#">
                            Page {{pagination.current_page}} of {{pagination.last_page}}
                        </a>
                    </li>
                    <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                        <a class="page-link" href="#" @click="fetchCategories(pagination.next_page_url)">Next</a>
                    </li>
                </ul>
            </nav>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Parent Category Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="category in categories" v-bind:key="category.id">
                        <td>{{category.name}}</td>
                        <td>{{category.parent_name}}</td>
                        <td>
                            <button @click="editCategory(category)" class="btn btn-warning mb-2">Edit</button>
                            <button @click="deleteCategory(category.id)" class="btn btn-danger">Delete</button>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>

    export default{
        /*components: {
            autocomplete
        },*/
        data() {
            return {
                categories:[],
                action: 'list',
                category: {
                    id: '',
                    name: '',
                    parent_id: '',
                    parent_name: ''
                },
                pagination: {},
                edit: false,
                //selection: '',
                suggestions: []
            }
        },

        created() {
            this.fetchCategories();
        },

        methods: {

            /*bindSuggestion(value) {

                fetch('api/autocomplete', {
                    method: 'post',
                    body: JSON.stringify({'name': value}),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.suggestions = res.data;

                })
                .catch(err => console.log(err));

            },*/

            createCategory() {
                this.action = 'add';
            },

            showCategory(id) {
                this.action = 'show';
                fetch('api/category/'+id, {
                    method: 'get'
                })
                    .then(res => res.json())
                    .then(data => {
                        alert('Category removed');
                        this.fetchCategories();
                    })
                    .catch(err => console.log(err));
            },

            fetchCategories(page_url) {
                this.action = 'list';
                this.category = {};
                this.edit = false;

                let vm = this;
                page_url = page_url || 'api/categories';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        //console.log(res.data);
                        this.categories = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },

            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page : meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };

                this.pagination = pagination;
            },


            deleteCategory(id) {
                if (confirm('Are you sure?')) {
                    fetch('api/category/'+id, {
                        method: 'delete'
                    })
                        .then(res => res.json())
                        .then(data => {
                            alert('Category removed');
                            this.fetchCategories();
                        })
                        .catch(err => console.log(err));
                }
            },

            addCategory() {
                if (this.edit === false) {

                    fetch('api/category', {
                        method: 'post',
                        body: JSON.stringify(this.category),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.category.name = '';
                        alert('Category added');
                        this.fetchCategories();
                    })
                    .catch(err => console.log(err));
                } else {
                    // update
                    fetch('api/category', {
                        method: 'put',
                        body: JSON.stringify(this.category),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.category = {};
                        alert('Category updated');
                        this.fetchCategories();
                    })
                    .catch(err => console.log(err));
                }
            },

            editCategory(category) {
                this.edit = true;
                this.action = 'add';
                this.category.id = category.id;
                this.category.name = category.name;
                this.category.parent_id = category.parent_id;
                this.category.parent_name = category.parent_name;
            }
        }
    };
</script>
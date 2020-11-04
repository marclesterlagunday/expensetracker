<template>
    <div id="role_content">
        <!-- Card -->
        <div class="card">
            <div class="card-header">{{ page_name }} <span class="float-right">User Management > {{ page_name }}</span></div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Display Name</th>
                            <th scope="col">Description</th>
                            <th scope="col">Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="role in roles" :key="role.role_id" @click="editRoleModal(role.role_id)" title="click to edit role" :class="role.role_id != 1 ? 'cursor-pointer' : ''">
                            <td>{{ role.role_name }}</td>
                            <td>{{ role.role_description }}</td>
                            <td>{{ role.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="toolbox w-100">
                    <nav class="float-left">
                        <ul class="pagination pagination-sm">
                            <li :class="[{ disabled: !pagination.prev_page_url }]" class="page-item"><a @click="fetchRoles(pagination.prev_page_url)" class="page-link" href="#">Previous</a></li>
                            <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                            <li :class="[{ disabled: !pagination.next_page_url }]" class="page-item"><a @click="fetchRoles(pagination.next_page_url)" class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                    <button @click="addRoleModal()" class="btn btn-primary btn-sm float-right"><i class="fa fa-plus-circle"></i> Add New {{ module_name }}</button>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade show" id="role_modal" tabindex="-1" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ modal_title }} {{ module_name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <!-- Form -->
                    <form @submit.prevent="storeRole()">
                        <div class="modal-body">
                            <div class="form-group row">
                                <label for="inputRoleName" class="col-sm-3 col-form-label">Display Name</label>
                                <div class="col-sm-9">
                                    <input v-model="role.role_name" type="text" class="form-control" id="inputRoleName" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputRoleDescription" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea v-model="role.role_description" class="form-control" id="inputRoleDescription" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="edit" @click="deleteRole(role.id)" type="button" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">{{ submit_button }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                page_name: 'Roles',
                module_name: 'Role',
                modal_title: 'Create',
                submit_button: 'Save',
                roles: [],
                role: {
                    id: '',
                    role_name: '',
                    role_description: ''
                },
                pagination: {},
                edit: false
            }
        },

        methods: {
            fetchRoles(page_url) {
                let vm = this;
                page_url = page_url || 'api/role_list';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.roles = res.data;
                        vm.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                }

                this.pagination = pagination;
            },
            fetchOneRole(id) {
                fetch('api/role_list/'+id)
                    .then(res => res.json())
                    .then(res => {
                        this.role.id = res.data.role_id
                        this.role.role_name = res.data.role_name;
                        this.role.role_description = res.data.role_description;
                    });
            },
            addRoleModal() {
                $('#role_modal').modal('show');
                this.edit = false;
                this.modal_title = 'Create';
                this.submit_button = 'Save';
                this.role.role_name = '';
                this.role.role_description = '';
            },
            editRoleModal(id) {
                if(id != 1){
                    $('#role_modal').modal('show');
                    this.edit = true;
                    this.modal_title = 'Edit';
                    this.submit_button = 'Update'
                    this.fetchOneRole(id);
                }
            },
            storeRole() {
                if(!this.edit) {
                    //Add Role
                    fetch('api/role_store', {
                        method: 'post',
                        body: JSON.stringify(this.role),
                        headers: {
                            'Content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.role.role_name = '';
                        this.role.role_description = '';
                        alert('Role has been added');
                        this.fetchRoles();
                        $('#role_modal').modal('hide');
                    })
                    .catch(err => console.log(err));
                } else {
                    //Edit Role
                    fetch('api/role_store', {
                        method: 'put',
                        body: JSON.stringify(this.role),
                        headers: {
                            'Content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.role.role_name = '';
                        this.role.role_description = '';
                        alert('Role has been updated');
                        this.fetchRoles();
                        $('#role_modal').modal('hide');
                    })
                    .catch(err => console.log(err));
                }
            },
            deleteRole(id) {
                if(confirm('Are you sure you want to delete?')) {
                    fetch('api/role_delete/'+id, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        alert('Role has been removed');
                        this.fetchRoles();
                    })
                    .catch(err => console.log(err));
                    $('#role_modal').modal('hide');
                }
            }
        },

        mounted() {
            this.fetchRoles();
        }
    }
</script>
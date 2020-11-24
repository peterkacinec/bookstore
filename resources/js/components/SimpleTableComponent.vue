<template>
    <div class="table-responsive">
        <!-- start inline new entry -->
        <form class="py-2" v-if="config.config.inlineNew">
            <div class="d-flex flex-wrap">
                <div v-for="field in config.config.inlineNew.fields" :key="field.id"
                     :class="field.settings.divClass"
                >
                    <!-- ak field je input type = text, textarea -->
                    <input
                        v-if="field.type === 'text' || field.type === 'textarea'"
                        class="form-control form-control-sm"
                        :class="{'is-invalid': errors.hasOwnProperty(field.key)}"
                        :type="field.type"
                        :placeholder="field.label"
                        :name="field.key"
                        :id="field.key"
                        v-model="newEntry[field.key]"
                    >
                    <!-- ak field je input type = number -->
                    <input
                        v-if="field.type === 'number'"
                        class="form-control form-control-sm"
                        :class="{'is-invalid': errors.hasOwnProperty(field.key)}"
                        :type="field.type"
                        :placeholder="field.label"
                        :name="field.key"
                        :id="field.key"
                        v-model="newEntry[field.key]"
                        step="0.01"
                    >
                    <!-- ak field je select -->
                    <select
                        v-else-if="field.type === 'select'"
                        class="form-control form-control-sm"
                        :class="{'is-invalid': errors.hasOwnProperty(field.key)}"
                        v-model="newEntry[field.key]"
                        :required="field.settings['required']"
                    >
                        <option v-for="item in field.options" v-bind:value="item.id">{{item.value}}</option>
                    </select>
                    <!-- ak field je input type checkbox -->
                    <div class="form-check" v-else-if="field.type === 'checkbox'">
                        <input
                            class="form-check-input"
                            :class="{'is-invalid': errors.hasOwnProperty(field.key)}"
                            :type="field.type"
                            :name="field.key"
                            :id="field.key"
                            v-model="newEntry[field.key]"
                        >
                        <label class="form-check-label" :for="field.key">
                            {{ field.label }}
                        </label>
                    </div>
                    <!-- ak field je textarea -->
                    <div v-if="errors.hasOwnProperty(field.key)" class="invalid-feedback">{{ errors[field.key][0] }}</div>
                </div>
                <a
                    class="btn btn-sm btn-outline-success inline-button-create"
                    role="button"
                    :title="config.config.inlineNew.title"
                    style="height: max-content;"
                    href=""
                    v-if="config.config.inlineNew.action"
                    v-on:click="config.config.inlineNew.action ? handleActions(config.config.inlineNew.action, config.config.inlineNew.url) : null"
                    onclick="this.blur();"
                ><span class="material-icons">{{config.config.inlineNew.label}}</span></a>
            </div>
        </form>
        <!-- ends inline new entry -->
        <div class="d-flex justify-content-end" v-if="this.config.config.showPagination && this.config.config.showPerPageSelect">
            <div class="col col-sm-2">
                <select class="form-control form-control-sm" v-model="rows" @change="reloadData()">
                    <option v-for="item in this.config.config.itemsPerPage" :value="item">{{item}}</option>
                </select>
            </div>
        </div>

        <table class="table table-striped table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th
                        v-for="column in config.columns"
                        :key="column.key"
                        @click="column.settings.sortable ? (column.map ? sortBy(column.map) : sortBy(column.key)) : null"
                        style="cursor:pointer;"
                    >{{column.label}}
                        <img src="/images/icons/sort-alpha-down.svg" alt="" v-if="((column.key === sortKey || column.map === sortKey) && sortDirection === 'asc')">
                        <img src="/images/icons/sort-alpha-down-alt.svg" alt="" v-if="((column.key === sortKey || column.map === sortKey) && sortDirection === 'desc')">
                    </th>
                    <th style="width: 140px" v-if="config.actions.length > 0">{{config.actionColumnLabel}}</th>
                </tr>
                <tr v-if="config.config.searchable">
                    <th
                        v-if="column.settings.searchable"
                        v-for="column in config.columns"
                        :key="column.key"
                    >
                        <input
                            v-if="column.type !== 'select'"
                            class="form-control form-control-sm"
                            :type="column.type"
                            v-model="search[column.key]"
                            :placeholder="column.settings.placeholder"
                            @input="debounceSearch(column.key)"
                        >
                        <select v-else class="form-control form-control-sm" v-model="search[column.map]" @change="debounceSearch(column.key)">
                            <option v-for="(option, index) in column.options" :key="index" :value="option.id">{{option.value}}</option>
                        </select>
                    </th>
                    <th v-else></th>
                    <th v-if="config.actions.length > 0"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in source" :key="item.id">
                    <td class="align-middle" v-for="column in config.columns">{{ column.key ? item[column.key] :  item[column.map]}}</td>
                    <td v-if="config.actions.length > 0" class="align-middle" style="width: 150px">
                        <a
                            role="button"
                            v-for="action in config.actions"
                            :title=action.title
                            v-bind:href=buildUrl(action.url,item)
                            :class=action.class
                            :data-toggle="action.dataToggle || null"
                            :data-target="action.dataTarget || null"
                            v-on:click="action.dataToggle ? showModal(
                                    buildUrl(action.url,item),
                                    action.modalText,
                                    action.ajax,
                                    action.requestMethod,
                                    action.key,
                                    item
                                ) : null"
                        ><span class="material-icons">{{action.label}}</span></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="d-flex justify-content-between" v-if="this.config.config.showPagination">
            <div>
                {{pagination.from}} - {{pagination.to}} / {{pagination.total}}
            </div>
            <ul class="pagination pagination-sm">
                <li class="page-item" :class="{disabled:!pagination.prev_page_url}">
                    <a class="page-link" @click="reloadData(pagination.first_page_url)">&lt;&lt;</a>
                </li>
                <li class="page-item" :class="{disabled:!pagination.prev_page_url}">
                    <a class="page-link" @click="reloadData(pagination.prev_page_url)">&lt;</a>
                </li>
                <li v-for="item in pagination.last_page" :key="item" class="page-item" :class="{active: pagination.current_page === item}">
                    <a class="page-link" @click="reloadData(pagination.path + '?page=' + item)" onclick="this.blur();">{{item}}</a>
                </li>
                <li class="page-item" :class="{disabled:!pagination.next_page_url}">
                    <a class="page-link" @click="reloadData(pagination.next_page_url)">&gt;</a>
                </li>
                <li class="page-item" :class="{disabled:!pagination.next_page_url}">
                    <a class="page-link" @click="reloadData(pagination.last_page_url)">&gt;&gt;</a>
                </li>
            </ul>
        </div>
        <modal-component
            :config="{...modal}"
            v-on:ajaxModalSubmit="handleAjaxModalSubmit"
        ></modal-component>
    </div>
</template>

<script>
    export default {
        props: ['config'],
        data() {
            return {
                source: [],
                pagination: this.config.data.pagination || null,
                rows: this.config.config.numberOfRows || null,
                sortKey: this.config.config.sortKey || null,
                sortDirection: this.config.config.sortDirection || null,
                newEntry: {},
                modal: {
                    text: '',
                    url: '',
                    ajax: false,
                    requestMethod: '',
                },
                errors: {},
                search: {},
                debounce: null,
            }
        },
        mounted() {
            this.loadSourceData(this.config.data);
        },
        methods: {
            buildUrl(urlTemplate, data) {
                let resolvedUrl;
                let params = urlTemplate.match(/[^{\}]+(?=})/g);
                if (params) {
                    params.forEach(param => {
                        resolvedUrl = urlTemplate.replace(`{${param}}`,data[param]);
                    });
                } else {
                    resolvedUrl = urlTemplate;
                }

                return resolvedUrl;
            },
            showModal(url, text, ajax, requestMethod, key, item) {
                this.modal = {};
                if (key === 'passwordReset') {
                    this.modal.email = item['email'];
                }
                this.modal = Object.assign(this.modal, {url, text, ajax, requestMethod});
            },
            handleActions(action, url) {
                event.preventDefault();
                event.stopPropagation();
                switch (action) {
                    case 'createItem':
                        this.createItem(url);
                        break;
                };
            },
            createItem(url) {
                axios.post(url, this.newEntry)
                    .then(res => {
                        this.errors = {};
                        this.setDefaultValue();
                        this.reloadData();
                        flash({text: res.data.message, type:'success', timer:3000 });
                    }).catch(e => {
                        // console.log(e.response.data.errors);
                        this.errors = e.response.data.errors;
                        flash({text: `${e.response.data.message}`, type:'error', timer:null });
                    });
            },
            loadSourceData(data){
                //funkcia nacitava zdrojove data pre tabulku, struktura moze byt rozna, podla toho ci sa jedna o tabulku so strankovanim
                // alebo nie
                if (this.config.config.showPagination) {
                    this.source     = data.data;
                    this.pagination = data.pagination;
                } else {
                    this.source = data;
                }
            },
            reloadData(url = this.config.config.reloadUrl) {
                axios.get(url, {
                    params: {
                        sortKey: this.sortKey,
                        sortDirection: this.sortDirection,
                        rows: this.rows,
                        search: this.search
                    },
                    paramsSerializer: function (params) {
                        return decodeURIComponent( $.param(params))
                    }
                }).then(res => {
                    this.loadSourceData(res.data);
                }).catch(e => {
                    let message = e.response.data.errors ?? e;
                    flash({text: `reloadData: ${message}`, type:'error', timer:null });
                });
            },
            setDefaultValue() {
                //function for new entry in inline new mode
                this.newEntry = {};
            },
            handleAjaxModalSubmit(url, method, data = {}) {
                axios(url, {
                    method: method,
                    data
                }).then(res => {
                    flash({text: res.data.message, type:'success', timer:3000 });
                    this.reloadData();
                }).catch(e => {
                    let message = e.response.data.errors ?? e.response.data.message ?? e;
                    flash({text: message, type:'error', timer:null });
                });
            },
            sortBy(key) {
                // sortovanie podla stlpca. kluc moze byt bud key, alebo map parameter
                this.sortKey = key;
                this.sortDirection === 'asc' ? this.sortDirection = 'desc' : this.sortDirection = 'asc';
                this.reloadData();
            },
            debounceSearch(key) {
                clearTimeout(this.debounce);
                this.debounce = setTimeout(() => {
                    this.reloadData();
                }, 600);
            },
        },
    };
</script>

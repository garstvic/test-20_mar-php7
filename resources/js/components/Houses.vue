<template>
    <div>
        <h2>Houses</h2>
        <div class="container">
            <h4>Filters</h4>
            <form @submit.prevent="applyFilter" class="form-inline mb-5">
                <div class="form-group mx-sm-3 mb-2">
                    <label for="name" class="sr-only">Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Name" v-model="house.name">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="price_start" class="sr-only">Price Start</label>
                    <input type="text" class="form-control" id="price_start" placeholder="Price Start" v-model="house.price_start">
                </div>         
                <div class="form-group mx-sm-3 mb-2">
                    <label for="price_end" class="sr-only">Price End</label>
                    <input type="text" class="form-control" id="price_end" placeholder="Price End" v-model="house.price_end">
                </div>                
                <div class="form-group mx-sm-3 mb-2">
                    <label for="bathrooms" class="sr-only">Bathrooms</label>
                    <input type="text" class="form-control" id="bathrooms" placeholder="Bathrooms" v-model="house.bathrooms">
                </div>      
                <div class="form-group mx-sm-3 mb-2">
                    <label for="storeys" class="sr-only">Storeys</label>
                    <input type="text" class="form-control" id="storeys" placeholder="Storeys" v-model="house.storeys">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="garages" class="sr-only">Garages</label>
                    <input type="text" class="form-control" id="garages" placeholder="Garages" v-model="house.garages">
                </div>  
                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>
            <hr/>
        </div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchHouses(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchHouses(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>
        <div v-for="house in houses" v-bind:key="house.id" class="card card-body mb-2">
            <h3>{{ house.name }}</h3>
            <div class="container">
              <div class="row">
                <div class="col"><span class="badge badge-pill badge-success">price</span>&nbsp;{{ house.price }}</div>
                <div class="col"><span class="badge badge-pill badge-primary">bedrooms</span>&nbsp;{{ house.bedrooms }}</div>
                <div class="col"><span class="badge badge-pill badge-primary">bathrooms</span>&nbsp;{{ house.bathrooms }}</div>
                <div class="col"><span class="badge badge-pill badge-primary">storeys</span>&nbsp;{{ house.storeys }}</div>
                <div class="col"><span class="badge badge-pill badge-primary">garages</span>&nbsp;{{ house.garages }}</div>
              </div>
            </div>            
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                houses: [],
                house: {
                   id: '',
                   name: '',
                   price: '',
                   price_start: '',
                   price_end: '',
                   bedrooms: '',
                   bathrooms: '',
                   storeys: '',
                   garages: ''
                },
                house_id: '',
                pagination: {}
            }
        },
        
        created() {
            this.fetchHouses();
        },
        
        methods: {
            fetchHouses(page_url) {
                let vm = this;
                page_url = page_url || '/api/houses'
                fetch(page_url)
                    .then(res => res.json())
                    .then(res => {
                        this.houses = res.data;      
                        vm.makePagination(res.meta, res.links)
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
            applyFilter() {
                let vm = this;
                fetch('/api/search', {
                    method: 'post',
                    body: JSON.stringify(this.house),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(res => {
                    this.houses = res.data;
                    vm.makePagination(res.meta, res.links)
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>
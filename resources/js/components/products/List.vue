<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Obat</h3>

                <div class="card-tools">
                  <button class="btn btn-success" data-toggle="modal" data-target="#addNew">Tambah Data Obat <i class="fas fa-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Harga_Beli</th>
                        <th>Harga_Jual</th>
                        <th>Tanggal Input</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr v-for="product in products" :key="product.id">
                    <td>{{product.code}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.category.name}}</td>
                    <td>{{product.unit.name}}</td>
                    <td class="text-right">{{product.harga_beli | currency }}</td>
                    <td class="text-right">{{product.harga_jual | currency}}</td>
                    <td>{{product.created_at | aporioDate}}</td>
                    <td>
                        <a href="#">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#">
                            <i class="fa fa-trash red"></i>
                        </a>
                    </td>
                  </tr>
                  
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNewLabel">Tambah Data Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="createProduct" @keydown="form.onKeydown($event)">
            <div class="modal-body">
                <h4 class="box-title blue text-center">INFORMASI UMUM</h4>
                <hr />
                <div class="form-group">
                    <input v-model="form.code" type="text" name="code"
                        placeholder="Kode Obat"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('code') }">
                    <has-error :form="form" field="code"></has-error>
                </div>
                <div class="form-group">
                    <input v-model="form.name" type="text" name="name"
                        placeholder="Nama Obat"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                    <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                    <select name="category_id" id="category_id" v-model="form.category_id" class="form-control"
                    :class="{'is-invalid':form.errors.has('category_id')}">
                        <option value="">--Piih Kategori--</option>
                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                </div>
                <div class="form-group">
                    <select name="unit_id" id="unit_id" v-model="form.unit_id" class="form-control"
                    :class="{'is-invalid':form.errors.has('unit_id')}">
                        <option value="">--Piih Satuan--</option>
                        <option v-for="unit in units" :key="unit.id" :value="unit.id">{{ unit.name }}</option>
                    </select>
                    <has-error :form="form" field="unit_id"></has-error>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Stok</label>
                            <input v-model="form.stok" type="number" name="stok"
                                placeholder="Stok"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('stok') }">
                            <has-error :form="form" field="stok"></has-error>
                        </div>        
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Minimal Stok</label>
                            <input v-model="form.minStok" type="number" name="minStok"
                                placeholder="Stok Min"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('minStok') }">
                            <has-error :form="form" field="minStok"></has-error>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <select name="supplier_id" id="supplier_id" v-model="form.supplier_id" class="form-control"
                    :class="{'is-invalid':form.errors.has('supplier_id')}">
                        <option value="">--Piih Supplier--</option>
                        <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">{{ supplier.name }}</option>
                    </select>
                    <has-error :form="form" field="supplier_id"></has-error>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>
                                <input v-model="form.resepDokter" type="checkbox" name="resepDokter">
                                Resep Dokter
                            </label>
                        </div>        
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>
                                <input v-model="form.narkotika" type="checkbox" name="narkotika" >
                                Narkotika
                            </label>
                        </div>
                    </div>
                </div>
                <h4 class="box-title blue text-center">INFORMASI OBAT</h4>
                <hr />
                <div class="row">
                    <div class="col">
                        <div class="picture-container">
                            <div class="picture">
                                <img :src="url" class="picture-src" id="wizardPicturePreview" title="">
                                <input v-on:change="onFileChange($event)" type="file"  class="" id="wizard-picture">
                            </div>
                            <h6 class="">Choose Picture</h6>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <input v-model="form.kemasan" type="text" name="kemasan"
                                placeholder="Kemasan"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('kemasan') }">
                            <has-error :form="form" field="kemasan"></has-error>
                        </div>
                        <div class="form-group">
                            <textarea v-model="form.komposisi" type="text" name="komposisi"
                                placeholder="Komposisi"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('komposisi') }" />
                            <has-error :form="form" field="komposisi"></has-error>
                        </div>
                        <div class="form-group">
                            <input v-model="form.produsen" type="text" name="produsen"
                                placeholder="Produsen"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('produsen') }">
                            <has-error :form="form" field="produsen"></has-error>
                        </div>
                    </div>
                </div>
                <hr />
                <h4 class="box-title blue text-center">INFORMASI HARGA</h4>
                <hr />
                <div class="form-group">
                    <label>Harga Pokok</label>
                    <vue-numeric currency="Rp" separator="," v-model="form.harga_pokok"  name="harga_pokok"
                        class="form-control text-right" :class="{ 'is-invalid': form.errors.has('harga_pokok') }" />
                    <has-error :form="form" field="harga_pokok"></has-error>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Harga %</label>
                            <input v-model="form.perInPrice" type="number" name="perInPrice"
                                placeholder="%" v-on:change="convertPercentToNominal"
                                class="form-control text-center" :class="{ 'is-invalid': form.errors.has('perInPrice') }">
                            <has-error :form="form" field="perInPrice"></has-error>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <vue-numeric currency="Rp" separator="," v-model="form.harga_jual" name="harga_jual"
                                class="form-control text-right" :class="{ 'is-invalid': form.errors.has('harga_jual') }" />
                            <has-error :form="form" field="harga_jual"></has-error>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Diskon%</label>
                            <input v-model="form.diskonPer" type="number" name="diskonPer"
                                placeholder="Diskon %"
                                class="form-control text-center" :class="{ 'is-invalid': form.errors.has('diskonPer') }">
                            <has-error :form="form" field="diskonPer"></has-error>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Nominal Diskon</label>
                            <input v-model="form.diskonNom" type="number" name="diskonNom"
                                placeholder="Nominal"
                                class="form-control text-right" :class="{ 'is-invalid': form.errors.has('diskonNom') }">
                            <has-error :form="form" field="diskonNom"></has-error>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Diskon Per/</label>
                            <input v-model="form.diskonUnit" type="number" name="diskonUnit"
                                placeholder="Berlaku /pcs"
                                class="form-control text-center" :class="{ 'is-invalid': form.errors.has('diskonUnit') }">
                            <has-error :form="form" field="diskonUnit"></has-error>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Masa Berlaku</label>
                            <input v-model="form.batasDiskon" type="text" name="batasDiskon" id="datepicker"
                                placeholder="Masa berlaku diskon"
                                class="form-control text-right" :class="{ 'is-invalid': form.errors.has('batasDiskon') }">
                            <has-error :form="form" field="batasDiskon"></has-error>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button :disabled="form.busy" type="submit" class="btn btn-primary">Simpan</button>
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
                products:{},
                units:{},
                categories:{},
                suppliers:{},
                form: new Form({
                    code:'',
                    name:'',
                    category_id:'',
                    unit_id:'',
                    stok:0,
                    minStok:0,
                    supplier_id:'',
                    resepDokter:true,
                    narkotika:true,
                    gambar:'',
                    kemasan:'',
                    komposisi:'',
                    produsen:'',
                    harga_pokok:0,
                    perInPrice:0,
                    harga_jual:0,
                    diskonPer:0,
                    diskonNom:0,
                    diskonUnit:0,
                    batasDiskon:''
                }),
                url:'../images/noimage.png',
                avatar:''
            }
        },
        created() {
            this.loadProducts();
            Fire.$on('AfterCreate',()=>{
                this.loadProducts();
            });
        },
        methods: {
            loadProducts(){
                axios.get("api/products").then(({data}) => {
                    this.products = data.data.data;
                    this.categories = data.categories;
                    this.units = data.units;
                    this.suppliers = data.suppliers;
                });
            },
            getDataFiles: function(e){
                e.preventDefault();
                console.log(this.$refs.mygambar.value);
                this.form.gambar = this.$refs.mygambar.value;
                this.url = this.form.gambar =! '' ? this.form.gambar:'../images/noimage.png';
            },
            onFileChange(e) {
                var files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();

                reader.onload = (e) => {
                    this.url = e.target.result;
                    console.log(this.url);
                    this.form.gambar = this.url;
                };
                reader.readAsDataURL(file);
            },
            removeImage: function (item) {
                this.url = false; 
            },
            createProduct() {
                this.$Progress.start();
                this.form.post('api/products')
                .then(() =>{
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    toast({
                        type:'success',
                        title:'Product baru berhasil di simpan'
                    });
                    this.$Progress.finish();
                })
                .catch(() =>{

                });
            },
            convertPercentToNominal(){
                this.form.harga_jual = 
                    this.evil((this.form.harga_pokok * (this.form.perInPrice/100))) + this.form.harga_pokok;
            },
            convertNominalToPercent(){
                if(this.form.harga_pokok == 0){
                    //this.form.perInPrice = 0;
                    this.form.harga_jual = 0;
                }else{

                }
            },
            evil(fn) {
                return new Function('return ' + fn)();
            },
            priceFormat(price){
               return new Intl.NumberFormat('nl-NL').format(price);
            }
        }
    }
</script>

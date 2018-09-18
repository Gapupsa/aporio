<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Daftar Obat</h3>

                <div class="card-tools">
                  <button class="btn btn-success" @click="newModal">Tambah Data Obat <i class="fas fa-plus fa-fw"></i></button>
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
                    <td class="text-right">{{product.harga_pokok | currency }}</td>
                    <td class="text-right">{{product.harga_jual | currency}}</td>
                    <td>{{product.created_at | aporioDate}}</td>
                    <td>
                        <a href="#" @click="editModal(product)">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#" @click="deleteProduct(product.id)">
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
                <h5 class="modal-title" id="addNewLabel" v-show="!editMode">Tambah Data Obat</h5>
                <h5 class="modal-title" id="addNewLabel" v-show="editMode">Ubah Data Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="editMode ? updateProduct() : createProduct()" @keydown="form.onKeydown($event)">
            <div class="modal-body">
                <h4 class="box-title blue text-center">INFORMASI UMUM</h4>
                <hr />
                <div class="form-group">
                    <input v-model="form.name" type="text" name="name"
                        placeholder="Nama Obat" autocomplete="off"
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
                                placeholder="Stok" autocomplete="off"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('stok') }">
                            <has-error :form="form" field="stok"></has-error>
                        </div>        
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Minimal Stok</label>
                            <input v-model="form.minStok" type="number" name="minStok"
                                placeholder="Stok Min" autocomplete="off"
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
                                <input v-model="form.resepdokter" type="checkbox" name="resepDokter">
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
                <hr />
                <h4 class="box-title blue text-center">INFORMASI OBAT</h4>
                <hr />
                <div class="row">
                    <div class="col-sm-5">
                        <img class="img-fluid mb-3 mr-3" :src="url" alt="Photo">
                        <input v-on:change="onFileChange($event)" type="file"  class="" id="wizard-picture">
                        <div class="form-group mt-3">
                            <label>Tanggal Kadaluarsa</label>
                            <date-picker placeholder="Tanggal kadaluarsa" v-model="form.expireDate"  :config="options" name="expireDate"></date-picker>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="form-group">
                            <label>Kemasan</label>
                            <input v-model="form.kemasan" type="text" name="kemasan"
                                placeholder="Kemasan" autocomplete="off" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Komposisi</label>
                            <textarea v-model="form.komposisi" type="text" name="komposisi"
                                placeholder="Komposisi" autocomplete="off" class="form-control"/>
                        </div>
                        <div class="form-group">
                            <label>Produsen</label>
                            <input v-model="form.produsen" type="text" name="produsen"
                                placeholder="Produsen" autocomplete="off" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea v-model="form.deskripsi" type="text"
                                placeholder="Deskripsi" autocomplete="off"
                                class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Indikasi</label>
                            <textarea v-model="form.indikasi" type="text"
                                placeholder="Indikasi" autocomplete="off"
                                class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Dosis</label>
                            <textarea v-model="form.dosis" type="text"
                                placeholder="Dosis" autocomplete="off"
                                class="form-control" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Penyajian</label>
                            <textarea v-model="form.penyajian" type="text"
                                placeholder="Penyajian" autocomplete="off"
                                class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Perhatian</label>
                            <textarea v-model="form.perhatian" type="text"
                                placeholder="Perhatian" autocomplete="off"
                                class="form-control" />
                        </div>
                        <div class="form-group">
                            <label>Efek Samping</label>
                            <textarea v-model="form.efeksamping" type="text"
                                placeholder="Efek Samping" autocomplete="off"
                                class="form-control" />
                        </div>
                        
                    </div>
                </div>
                <hr />
                <h4 class="box-title blue text-center">INFORMASI HARGA</h4>
                <hr />
                <div class="form-group">
                    <label>Harga Pokok</label>
                    <vue-numeric currency="Rp" separator="," v-model="form.harga_pokok"  name="harga_pokok"
                        autocomplete="off"
                        class="form-control text-right" :class="{ 'is-invalid': form.errors.has('harga_pokok') }" />
                    <has-error :form="form" field="harga_pokok"></has-error>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Harga %</label>
                            <input v-model="form.perInPrice" type="number" name="perInPrice"
                                placeholder="%" @keyup="convertPercentToNominal" autocomplete="off"
                                class="form-control text-center" :class="{ 'is-invalid': form.errors.has('perInPrice') }">
                            <has-error :form="form" field="perInPrice"></has-error>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Harga Jual</label>
                            <vue-numeric currency="Rp" separator="," v-model="form.harga_jual" name="harga_jual"
                                autocomplete="off"
                                class="form-control text-right" @blur="convertNominalToPercent"
                                :class="{ 'is-invalid': form.errors.has('harga_jual') }" />
                            <has-error :form="form" field="harga_jual"></has-error>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>
                        <input v-model="form.isDiskon" type="checkbox" name="isDiskon">
                        Berlakukan Diskon:
                    </label>
                </div> 
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Diskon%</label>
                            <input v-model="form.diskonPer" type="number" name="diskonPer"
                                placeholder="Diskon %" autocomplete="off"
                                class="form-control text-center" :class="{ 'is-invalid': form.errors.has('diskonPer') }">
                            <has-error :form="form" field="diskonPer"></has-error>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Nominal Diskon</label>
                            <input v-model="form.diskonNom" type="number" name="diskonNom"
                                placeholder="Nominal" autocomplete="off"
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
                                placeholder="Berlaku /pcs" autocomplete="off"
                                class="form-control text-center" :class="{ 'is-invalid': form.errors.has('diskonUnit') }">
                            <has-error :form="form" field="diskonUnit"></has-error>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>Masa Berlaku</label>
                            <date-picker v-model="form.batasDiskon" :config="options" name="batasDiskon" ></date-picker>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button v-show="!editMode" :disabled="form.busy" type="submit" class="btn btn-info">Simpan</button>
                <button v-show="editMode" :disabled="form.busy" type="submit" class="btn btn-success">Ubah</button>
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
                editMode:false,
                options: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                }, 
                products:{},
                units:{},
                categories:{},
                suppliers:{},
                user:{},
                form: new Form({
                    id:'',
                    name:'',
                    category_id:'',
                    unit_id:'',
                    stok:0,
                    minStok:0,
                    supplier_id:'',
                    resepdokter:false,
                    narkotika:false,
                    isDiskon:false,
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
                    batasDiskon:'',
                    user_id: userId,
                    expireDate:'',
                    deskripsi:'',
                    komposisi:'',
                    indikasi:'',
                    dosis:'',
                    penyajian:'',
                    perhatian:'',
                    efeksamping:''
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
            changeDate() {
                //this.form.batasDiskon=val;
            },
            changeDate2() {
                //this.form.batasDiskon=val;
            },
            updateProduct(){
                swal({
                    title:'Yakin mengubah obat ini ?',
                    text:'Anda tidak dapat mengembalikan data yang telah dirubah!',
                    type:'warning',
                    showCancelButton:true,
                    confirmButtonColor:'#3085d6',
                    cancelButtonColor:'#d33',
                    confirmButtonText:'Ya, ubah saja!'
                }).then((result)=>{
                    if(result.value){
                        this.$Progress.start();
                        this.form.put('api/products/'+this.form.id)
                        .then(() => {
                            Fire.$emit('AfterCreate');
                            this.form.reset();
                            $('#addNew').modal('hide');
                            toast({
                                type:'success',
                                title:'Product berhasil di ubah'
                            });
                            this.$Progress.finish();
                        }).catch(() => {
                            this.$Progress.fail();
                            swal('Gagal!','Data obat Gagal diubah.','warning');
                        });
                    }
                })
                
            },
            newModal(){
                this.editMode=false;
                this.form.clear();
                this.form.reset();
                $('#addNew').modal('show');
            },
            editModal(product){
                this.editMode=true;
                this.form.clear();
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(product);
                console.log(this.form);
            },
            deleteProduct(id){
                swal({
                    title:'Yakin hapus obat ini ?',
                    text:'Anda tidak dapat mengembalikan data yang telah terhapus!',
                    type:'warning',
                    showCancelButton:true,
                    confirmButtonColor:'#3085d6',
                    cancelButtonColor:'#d33',
                    confirmButtonText:'Ya, hapus saja!'
                }).then((result)=>{
                    if(result.value){
                        this.form.delete('api/products/'+id).then(()=>{
                            swal('Terhapus!','Data obat berhasil dihapus.','success');
                            Fire.$emit('AfterCreate');
                        }).catch(()=>{
                            swal('Gagal!','Data obat Gagal dihapus.','warning');
                        });
                    }
                })
            },
            loadProducts(){
                axios.get("api/products").then(({data}) => {
                    this.products = data.data.data;
                    this.categories = data.categories;
                    this.units = data.units;
                    this.suppliers = data.suppliers;
                    this.user = data.user;
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
                if(file['size'] < 2111775){
                    reader.onload = (e) => {
                        this.url = e.target.result;
                        console.log(this.url);
                        this.form.gambar = this.url;
                    };
                    reader.readAsDataURL(file);
                }else{
                    swal('Ooops!','file gambar terlalu besar. disarankan kurang dari 2MB','error');
                }
            },
            removeImage: function (item) {
                this.url = false; 
            },
            createProduct() {
                swal({
                    title:'Yakin menambah obat ini ?',
                    text:'Pastikan seluruh data yang di masukkan benar!',
                    type:'warning',
                    showCancelButton:true,
                    confirmButtonColor:'#3085d6',
                    cancelButtonColor:'#d33',
                    confirmButtonText:'Ya, tambah saja!'
                }).then((result)=>{
                    if(result.value){
                        this.$Progress.start();
                        this.form.post('api/products')
                        .then(() =>{
                            Fire.$emit('AfterCreate');
                            this.form.reset();
                            $('#addNew').modal('hide');
                            toast({
                                type:'success',
                                title:'Product baru berhasil di simpan'
                            });
                            this.$Progress.finish();
                        })
                        .catch(() =>{
                            this.$Progress.fail();
                            swal('Gagal!','Data obat Gagal ditambahkan.','warning');
                        });
                    }
                })
                
            },
            convertPercentToNominal(){
                this.form.harga_jual = 
                    this.evil((this.form.harga_pokok * (this.form.perInPrice/100))) + this.form.harga_pokok;
            },
            convertNominalToPercent(){
                console.log('tes');
                this.form.perInPrice = 
                    this.evil(((this.form.harga_jual - this.form.harga_pokok)/this.form.harga_pokok) * 100);
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

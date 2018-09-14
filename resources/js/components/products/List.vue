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
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>Kategori</th>
                        <th>Satuan</th>
                        <th>Harga_Beli</th>
                        <th>Harga_Jual</th>
                        <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <tr>
                    <td>183</td>
                    <td>John Doe</td>
                    <td>11-7-2014</td>
                    <td>11-7-2014</td>
                    <td>11-7-2014</td>
                    <td><span class="tag tag-success">Approved</span></td>
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
            <div class="modal-body">
                <h4 class="box-title blue">INFORMASI UMUM</h4>
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
                        <option value="1">INJEKSI</option>
                        <option value="2">KULIT</option>
                        <option value="3">KUMUR</option>
                        <option value="4">LUAR</option>
                        <option value="5">MATA</option>
                    </select>
                    <has-error :form="form" field="category_id"></has-error>
                </div>
                <div class="form-group">
                    <select name="unit_id" id="unit_id" v-model="form.unit_id" class="form-control"
                    :class="{'is-invalid':form.errors.has('unit_id')}">
                        <option value="">--Piih Satuan--</option>
                        <option value="1">BOX</option>
                        <option value="2">BOTOL</option>
                        <option value="3">CAPSUL</option>
                        <option value="4">KG</option>
                        <option value="5">MG</option>
                    </select>
                    <has-error :form="form" field="unit_id"></has-error>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <input v-model="form.stok" type="number" name="stok"
                                placeholder="Stok"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('stok') }">
                            <has-error :form="form" field="stok"></has-error>
                        </div>        
                    </div>
                    <div class="col">
                        <div class="form-group">
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
                        <option value="1">LUKMAN</option>
                        <option value="2">ABDEE</option>
                    </select>
                    <has-error :form="form" field="supplier_id"></has-error>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label>
                                <input v-model="form.resepDokter" type="checkbox" name="resepDokter" class="minimal">
                                Resep Dokter
                            </label>
                        </div>        
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label>
                                <input v-model="form.narkotika" type="checkbox" name="narkotika" class="minimal">
                                Narkotika
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Simpan</button>
            </div>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                form: new Form({
                    code:'',
                    name:'',
                    category_id:'',
                    unit_id:'',
                    stok:'',
                    minStok:'',
                    supplier_id:'',
                    resepDokter:false,
                    narkotika:false,
                    gambar:'',
                    kemasan:'',
                    komposisi:'',
                    produsen:'',
                    harga_pokok:'',
                    perInPrice:'',
                    harga_jual:'',
                    diskonPer:'',
                    diskonNom:'',
                    diskonUnit:'',
                    batasDiskon:''
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

@extends('layouts.app')

@section('content')
<div class="page height-full">
    <!-- <header class="red accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                         <i class="icon icon-dashboard"></i> 
                        Dashboard 
                    <   /h4>
                </div>
            </div>
        </div>
    </header> -->
    <div class="naik">
        <img class="mt-n5" src="https://privy.id/images/landing/bg-landing.jpg" width="100%" height="400">
    </div>

    <div class="container my-5">
        <div class="row justify-content-center">
            <p class="text-center text-black">
                PrivyID didirikan di Jakarta pada tahun 2016 dengan misi menghadirkan teknologi yang memberikan identitas tunggal yang terintegrasi secara universal di dunia digital bagi penggunanya. Sebagai perusahaan yang telah terdaftar dan diakui oleh pemerintah Indonesia melalui Kementerian Komunikasi dan Informatika (Kominfo), PrivyID memiliki otoritas untuk menerima pendaftaran, memverifikasi, serta menerbitkan sertifikat elektronik dan tanda tangan elektronik bagi warga negara Indonesia. Seluruh tanda tangan elektronik yang dibuat dengan aplikasi PrivyID memiliki kekuatan dan akibat hukum yang sah selayaknya tanda tangan basah. Keamanan informasi data pengguna aplikasi PrivyID terjamin melalui penggunaan teknologi asymmetric cyrptography.
            </p>

            <!-- <h2 class="my-5 text-black">PIMPINAN</h2> -->
        
        </div>

    <!-- <div class="row my-4 justify-content-center text-center">
        @foreach($pimpinans as $pis)
        <div class="col-md-6">
        <a href=""></a>
        <img src="{{asset('/images/ava/'.$pis->foto)}}" width="100" height="100">
            <h5 class="text-black">
                {{$pis->nama}}
            </h5>
            <h4 class="text-black">
                {{$pis->jabatan}}
            </h4> -->
            <!-- <a class="btn btn-light w-5" href="">EDIT</a>
            <form action="/home/{{$pis->id}}" method="post">
            @method('delete')
            @csrf
               <button type="submit" class="btn btn-danger w-5">delete
               </button>
            </form> -->
        <!-- </div> -->
        <!-- @endforeach -->
        <!-- <a href=""><i class="far fa-add"></i>add</a> -->
        
        <!-- <div class="col-md-6">
        <img src="" width="100" height="100">
            <h5 class="text-black">
                nama
            </h5>
            <h4 class="text-black">
                jabatan
            </h4>
        </div> -->
    <!-- </div>   -->

    <!-- <div class="row container justify-content-center my-5"> -->
        <!-- <a href=""><i class="fa fa-plus black"></i><h5 class="text-black">ADD</h5></a> -->

            <!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
  <i class="fa fa-plus"></i>ADD
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog text-white" role="document">
    <div class="modal-content bg-danger">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">ADD</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                    <form action="{{action('HomeController@store')}}" enctype="multipart/form-data" method="post">
                    @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">NAMA</label>
                <input type="text" class="form-control" id="nama" name="nama" aria-describedby="emailHelp" placeholder="jhon">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">JABATAN</label>
                <input type="text" name="jabatan" class="form-control" id="jabatan" placeholder="atasan">
            </div>
                    <div class="form-group">
            <label for="exampleFormControlFile1">Picture</label>
            <input type="file" class="form-control-file" id="foto" name="foto">
        </div>
            <!-- <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                
        </div>
        <div class="modal-footer bg-danger text-white">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-light">Save changes</button>
        </div>
        </form>
        </div>
    </div>
</div>
<!-- Modal -->


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog text-white" role="document">
    <div class="modal-content bg-danger">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">EDIT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                    <form action="/home/{{$pis->id}}" enctype="multipart/form-data" method="post">
                    {{method_field('patch')}}
                    @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">NAMA</label>
                
                <input type="text" class="form-control" id="nama" name="nama" aria-describedby="emailHelp">
                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">JABATAN</label>
                <input type="text" name="jabatan" class="form-control" id="jabatan">
            </div>
                    <div class="form-group">
            <label for="exampleFormControlFile1">Picture</label>
            <input type="file" class="form-control-file" id="foto" name="foto">
        </div>
            <!-- <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div> -->
            <!-- <button type="submit" class="btn btn-primary">Submit</button> -->
                
        </div>
        <div class="modal-footer bg-danger text-white">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-light">Save changes</button>
        </div>
        </form>
        </div>
    </div>
</div>
<!-- Edit Modal -->
    
    </div>  


    
    </div>

<div class="p4"></div>
          <hr>
          <div class="col-sm-12">
            <br>
            <h3 class="text-center">Pimpinan</h3>
            <br>
            <br>
            <br>
            <div class="row text-center">
            @foreach($pimpinans as $pis)
                      <div class="mx-auto col-sm-4 col-xs-4 pb-4 mb-4">
                        <img class="rounded-circle z-depth-2 " src="{{asset('/images/ava/'.$pis->foto)}}" alt="" width="200" class="pb-3">
                        <h4>{{$pis->nama}}</h4>
                        <p>{{$pis->jabatan}}</p>

                          <!-- <form  class="mx-auto" action="/home/{{$pis->id}}" method="post">
                          
                          @csrf
                            <button type="submit" class="btn btn-light w-5">EDIT
                            </button>
                          </form> -->
                          <a  class="mx-auto btn btn-light" 
                          id="editBtn"

                          data-toggle="modal" data-target="#editModal"
                          
                          data-nama="{{$pis->nama}}"
                          data-jabatan="{{$pis->jabatan}}"
                          >EDIT
                          </a>
                          <!-- <a href="../home/{{$pis->id}}" class="btn btn-light w-5">EDIT
                            </a> -->
                          <form  class="mx-auto" action="/home/{{$pis->id}}" method="post">
                    @method('delete')
                    @csrf
                      <button type="submit" class="btn btn-danger w-5">DELETE
                      </button>
                    </form>
                      </div>
            @endforeach
              </div>
            
<!-- <a class="btn btn-light w-5" href="">EDIT</a> -->
            
              <!-- <div class="mx-auto col-sm-4  col-xs-4 pb-4 mb-4">
                <img src="https://privy.id/assets.1.7.2/img/abby.png" alt="" width="200" class="pb-3">
                <h4>Guritno Adi Saputra</h4>
                <p>CTO &amp; CO-FOUNDER</p>
              </div> -->
              <!--					<div class="col-sm-4 col-xs-4">
                    <img src="https://privy.id//main/img/Asset/7. The Pioneers - Ajisatria.png" alt=""  width="200">
                    <h4>Ajisatria Suleiman</h4>
                    <p>PUBLIC POLICY STRATEGIST & CO-FOUNDER</p>
                  </div> -->
            </div>

            
          </div>
          <div class="row justify-content-center">
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
              <i class="fa fa-plus"></i>ADD
                </button>
            </div>
          <div class="clearfix"></div>
          <div class="col-sm-12">
            <br>
            <!-- <div class="row text-center">
              <div class="mx-auto col-sm-4 col-xs-4 pb-4 mb-4">
                <img src="https://privy.id/assets.1.7.2/img/andre.png" alt="" width="180" class="pb-3">
                <h4>Johan Andreas</h4>
                <p>EVP Business Development</p>
              </div>
              <div class="mx-auto col-sm-4 col-xs-4 pb-4 mb-4">
                <img src="https://privy.id/assets.1.7.2/img/khrisna.png" alt="" width="180" class="pb-3">
                <h4>Krishna Chandra</h4>
                <p>EVP Security</p>
              </div>
            </div> -->
          </div>

        </div>
      </div>
      <br/>
      <br/>
      <hr>
      <br/>
      <br/>
      <div class="p-2"></div>
      <h5 class="text-center">Penghargaan</h5>
      <p class="text-center">Dalam usia muda, PrivyID telah berhasil mendapatkan penghargaan dari berbagai lembaga ternama</p>
      <div class="p-4"></div>
      <div class="row text-center clients justify-content-center">
        <div class="col-md-3 text-center align-self-center">
          <img class="pb-4 pt-2" src="https://privy.id/assets.1.7.2/img/dea.png" alt="">
        </div>
        <div class="col-md-3 text-center align-self-center">
          <img class="pb-4 pt-2" src="https://privy.id/assets.1.7.2/img/e27top100.png" alt="">
        </div>
        <div class="col-md-3 text-center align-self-center">
          <img class="pb-4 pt-2" src="https://privy.id/assets.1.7.2/img/finspire.jpg" alt="">
        </div>
        <div class="col-md-3 text-center align-self-center">
          <img class="pb-4 pt-2" src="https://privy.id/assets.1.7.2/img/forbes.png" alt="">
        </div>
      </div>
    </div>
  </div>
  <!-- /.section--wrapper -->
  </div>
  <!-- /.container -->


    
    <!-- <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content pb-3" id="v-pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">
            </div>
        </div>
    </div> -->
</div>

<script>
$(document).ready(function(){
  $(document).on('click', '#editBtn', function(){
    //  dd('dasd');
     var nama = $(this).data('nama');
     var jabatan = $(this).data('jabatan');
     
     var modal = $(this)
     modal.find('.modal-body #nama').val(nama);
     modal.find('.modal-body #jabatan').val(jabatan);
  })
})
</script>


@endsection
<div class="modal fade" id="akses-form" tabindex="-1" role="dialog" aria-labelledby="akses-form">
    <div class="modal-dialog modal-xl" role="document">
        <form action="" method="post" id="aksesForm" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                    </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8 col-lg-8">

                            <div id="menu-list"></div>
                
            </div>
        </div>
        </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-sm btn-flat btn-warning" data-dismiss="modal"><i class="fa fa-arrow-circle-left"></i> Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- modalsearch -->
<div id="fsModalSearch"
     class="modal animated fadeInDown"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true">
    <!-- dialog -->
    <div class="modal-dialog">
        <!-- content -->
        <div class="modal-content">
            <!-- header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">{{icon('times','fa-lg')}}</button>
                <form action="#">
                    <div class="search-group">
                        <label class="search-label">{{icon('search','fa-lg')}}</label>
                        <input  class="search-input" type="text" placeholder="Search by code or description" name="search">
                    </div>
                </form>
            </div>
            <!-- header -->
            <!-- body -->
            <div class="modal-body">
                <div class="search-result"></div>
            </div>
            <!-- body -->
            <!-- footer -->
            <div class="modal-footer">
                <div class="container searched-word-box">
                    <div class="row">
                        <div class="col-xs-12">
                            Visualizza tutti i risultati per: <span class="searched-word"></span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- footer -->
        </div>
        <!-- content -->
    </div>
    <!-- dialog -->
</div>
<div class="mx-3 mt-5">
    <div class="card mt-2 p-3 mb-1 d-flex">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <!-- Search Bar and Print Button -->
            <div class="d-flex align-items-center gap-2">
                <input type="text" class="form-control form-control-sm" placeholder="Search..." />

            </div>

            <!-- Action Buttons -->
            <div class="button-group d-flex gap-2">
                <button class="btn btn-info text-white btn-sm">
                    <i class="fas fa-print"></i> Print
                </button>
                <button class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Add Record
                </button>

            </div>
        </div>
    </div>


    <div class="card ">
        <div class="d-flex justify-content-end p-3 gap-3">
            <button class="btn btn-sm btn-success btn-custom-c" wire:click="showTemplate('front')">Show Front</button>
            <button class="btn btn-sm btn-success btn-custom-c" wire:click="showTemplate('back')">Show Back</button>
        </div>

        <iframe id="pdfFrame" src="{{ route('pdf.guest') }}?page={{ $page }}" width="100%" height="600px"
            frameborder="0"></iframe>

    </div>

</div>
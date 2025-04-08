<div class="mx-3">
    <div class="card mt-2 mb-1">
        FILTER
    </div>
    <div class="card ">
   
        <div class="d-flex justify-content-end p-3 gap-3">
            <button class="btn btn-sm btn-success btn-custom-c" wire:click="showTemplate('front')">Show Front</button>
            <button class="btn btn-sm btn-success btn-custom-c" wire:click="showTemplate('back')">Show Back</button>
        </div>
   
        <iframe id="pdfFrame" src="{{ route('pdf.template') }}?page={{ $page }}" width="100%" height="600px"
            frameborder="0"></iframe>
   
    </div>
   
</div>
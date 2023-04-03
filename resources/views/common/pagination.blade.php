@if ($paginator->hasPages())
    <div class="border-top-light mt-30 pt-30">
        <div class="row x-gap-10 y-gap-20 justify-between md:justify-center">
            <div class="col-auto md:order-1">
                @if ($paginator->onFirstPage())
                    <button class="button -blue-1 size-40 rounded-full border-light">
                        <i class="icon-chevron-left text-12"></i>
                    </button>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <button class="button -blue-1 size-40 rounded-full border-light">
                            <i class="icon-chevron-left text-12"></i>
                        </button>
                    </a>
                @endif
            </div>

            <div class="col-md-auto md:order-3">

                <div class="row x-gap-20 y-gap-20 items-center md:d-none">
                    @if ($paginator->currentPage() > 3)
                        <div class="col-auto">
                            <a href="{{ $paginator->url(1) }}">
                                <div class="size-40 flex-center rounded-full">1</div>
                            </a>
                        </div>
                    @endif
                    @if ($paginator->currentPage() > 4)
                        <div class="col-auto">
                            <div class="size-40 flex-center rounded-full">...</div>
                        </div>
                    @endif
                    @foreach (range(1, $paginator->lastPage()) as $i)
                        @if ($i >= $paginator->currentPage() - 2 && $i <= $paginator->currentPage() + 2)
                            @if ($i == $paginator->currentPage())
                                <div class="col-auto">
                                    <div class="size-40 flex-center rounded-full bg-dark-1 text-white">
                                        {{ $i }}
                                    </div>
                                </div>
                            @else
                                <div class="col-auto">
                                    <a href="{{ $paginator->url($i) }}">
                                        <div class="size-40 flex-center rounded-full">{{ $i }}</div>
                                    </a>
                                </div>
                            @endif
                        @endif
                    @endforeach
                    @if ($paginator->currentPage() < $paginator->lastPage() - 3)
                        <div class="col-auto">
                            <div class="size-40 flex-center rounded-full">...</div>
                        </div>
                    @endif
                    @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                        <div class="col-auto">
                            <a href="{{ $paginator->url($paginator->lastPage()) }}">
                                <div class="size-40 flex-center rounded-full">{{ $paginator->lastPage() }}</div>
                            </a>
                        </div>
                    @endif
                </div>
                <div class="row x-gap-10 y-gap-20 justify-center items-center d-none md:d-flex">
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full">1</div>
                    </div>
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full bg-dark-1 text-white">2</div>
                    </div>
                    <div class="col-auto">
                        <div class="size-40 flex-center rounded-full">3</div>
                    </div>
                </div> 
                 <div class="text-center mt-30 md:mt-10">
                    <div class="text-14 text-light-1">1 – {{ $paginator->lastPage() }} of {{ $hotelCount }}+ properties found</div>
                </div>
            </div>

            <div class="col-auto md:order-2">
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <button class="button -blue-1 size-40 rounded-full border-light">
                            <i class="icon-chevron-right text-12"></i>
                        </button>
                    </a>
                @else
                    <button class="button -blue-1 size-40 rounded-full border-light">
                        <i class="icon-chevron-right text-12"></i>
                    </button>
                @endif



            </div>
        </div>
    </div>
@endif

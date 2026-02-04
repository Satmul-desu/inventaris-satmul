@extends('layouts.admin')

@section('title', 'Detail: ' . ($sandbox->subject ?: 'Thread'))

@section('content')
<div class="row">
    <div class="col-lg-9">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.sandbox.index') }}">Sandbox</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $sandbox->subject ?: 'Tanpa Subjek' }}</li>
            </ol>
        </nav>

        <!-- Original Question -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if($sandbox->is_pinned)
                        <span class="badge badge-light mr-2"><i class="fa fa-thumbtack"></i> Dipin</span>
                        @endif
                        @if($sandbox->priority === 'high')
                        <span class="badge badge-warning mr-2"><i class="fa fa-exclamation"></i> Penting</span>
                        @endif
                        <h5 class="mb-0 d-inline">{{ $sandbox->subject ?: 'Tanpa Subjek' }}</h5>
                    </div>
                    <small>
                        {{ $sandbox->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
            </div>
            <div class="card-body">
                <div class="media">
                    <div class="mr-3">
                        @if($sandbox->sender && $sandbox->sender->photo)
                        <img src="{{ asset('storage/' . $sandbox->sender->photo) }}" 
                             class="rounded-circle" width="50" height="50" alt="Avatar">
                        @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                             style="width: 50px; height: 50px;">
                            <i class="fa fa-user"></i>
                        </div>
                        @endif
                    </div>
                    <div class="media-body">
                        <h6 class="mt-0">{{ $sandbox->sender->name ?? 'Unknown' }}</h6>
                        <p class="mb-0">{!! nl2br(e($sandbox->message)) !!}</p>
                    </div>
                </div>
            </div>
            @if(auth()->user()->isOwner())
            <div class="card-footer d-flex justify-content-between align-items-center">
                <div>
                    @if($sandbox->status === 'open')
                    <span class="badge badge-warning"><i class="fa fa-clock"></i> Menunggu Jawaban</span>
                    @elseif($sandbox->status === 'answered')
                    <span class="badge badge-success"><i class="fa fa-check"></i> Sudah Dijawab</span>
                    @else
                    <span class="badge badge-secondary"><i class="fa fa-lock"></i> Ditutup</span>
                    @endif
                </div>
                <div>
                    @if($sandbox->status !== 'closed')
                    <a href="{{ route('admin.sandbox.close', $sandbox->id) }}" 
                       class="btn btn-sm btn-outline-secondary" 
                       onclick="return confirm('Tutup thread ini?')">
                        <i class="fa fa-lock"></i> Tutup
                    </a>
                    @else
                    <a href="{{ route('admin.sandbox.reopen', $sandbox->id) }}" 
                       class="btn btn-sm btn-outline-success">
                        <i class="fa fa-unlock"></i> Buka Lagi
                    </a>
                    @endif
                    @if(!$sandbox->is_pinned)
                    <a href="{{ route('admin.sandbox.pin', $sandbox->id) }}" class="btn btn-sm btn-outline-danger">
                        <i class="fa fa-thumbtack"></i> Pin
                    </a>
                    @else
                    <a href="{{ route('admin.sandbox.pin', $sandbox->id) }}" class="btn btn-sm btn-outline-warning">
                        <i class="fa fa-times"></i> Unpin
                    </a>
                    @endif
                    <form action="{{ route('admin.sandbox.destroy', $sandbox->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                onclick="return confirm('Hapus thread ini beserta semua balasan?')">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Replies -->
        @if($sandbox->replies->count() > 0)
        <div class="ml-4">
            <h6 class="mb-3"><i class="fa fa-comments"></i> {{ $sandbox->replies->count() }} Jawaban</h6>
            @foreach($sandbox->replies as $reply)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="media">
                        <div class="mr-3">
                            @if($reply->sender && $reply->sender->photo)
                            <img src="{{ asset('storage/' . $reply->sender->photo) }}" 
                                 class="rounded-circle" width="45" height="45" alt="Avatar">
                            @else
                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" 
                                 style="width: 45px; height: 45px;">
                                <i class="fa fa-user"></i>
                            </div>
                            @endif
                        </div>
                        <div class="media-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="mt-0">{{ $reply->sender->name ?? 'Unknown' }}</h6>
                                <small class="text-muted">{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                            <p class="mb-0">{!! nl2br(e($reply->message)) !!}</p>
                        </div>
                    </div>
                </div>
                @if(auth()->user()->isOwner())
                <div class="card-footer py-2 bg-light">
                    @if($reply->type === 'answer')
                    <span class="badge badge-success"><i class="fa fa-check"></i> Jawaban</span>
                    @endif
                    <form action="{{ route('admin.sandbox.destroy', $reply->id) }}" method="POST" class="d-inline float-right">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger py-0" 
                                onclick="return confirm('Hapus balasan ini?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        <!-- Reply Form -->
        @if($sandbox->status !== 'closed' && auth()->user()->isOwner())
        <div class="card mt-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fa fa-reply"></i> Balas Pertanyaan</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.sandbox.reply', $sandbox->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="replyMessage">Jawaban Anda <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="replyMessage" name="message" rows="4" 
                                  placeholder="Tulis jawaban Anda di sini..." required></textarea>
                        @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.sandbox.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-send"></i> Kirim Jawaban
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @elseif($sandbox->status === 'closed')
        <div class="alert alert-secondary">
            <i class="fa fa-lock"></i> Thread ini sudah ditutup. Tidak dapat membalas.
        </div>
        @endif
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fa fa-info-circle"></i> Info Thread</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <strong>Status:</strong><br>
                        @if($sandbox->status === 'open')
                        <span class="badge badge-warning">Menunggu</span>
                        @elseif($sandbox->status === 'answered')
                        <span class="badge badge-success">Selesai</span>
                        @else
                        <span class="badge badge-secondary">Ditutup</span>
                        @endif
                    </li>
                    <li class="mb-2">
                        <strong>Pemula:</strong><br>
                        {{ $sandbox->sender->name ?? 'Unknown' }}
                    </li>
                    <li class="mb-2">
                        <strong>Dibuat:</strong><br>
                        {{ $sandbox->created_at->format('d/m/Y H:i') }}
                    </li>
                    <li class="mb-2">
                        <strong>Jawaban:</strong><br>
                        {{ $sandbox->replies->count() }}
                    </li>
                    @if($sandbox->replies->last())
                    <li>
                        <strong>Terakhir:</strong><br>
                        {{ $sandbox->replies->last()->created_at->diffForHumans() }}
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        @if(auth()->user()->isOwner())
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="fa fa-link"></i> Menu</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin.sandbox.index') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-list"></i> Semua Thread
                    </a>
                    <a href="{{ route('admin.sandbox.filter', 'open') }}" class="list-group-item list-group-item-action">
                        <i class="fa fa-question-circle"></i> Belum Dijawab
                    </a>
                    <button class="list-group-item list-group-item-action" data-toggle="modal" data-target="#newQuestionModal">
                        <i class="fa fa-plus"></i> Pertanyaan Baru
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Modal Pertanyaan Baru -->
@if(auth()->user()->isOwner())
<div class="modal fade" id="newQuestionModal" tabindex="-1" role="dialog" aria-labelledby="newQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newQuestionModalLabel">
                    <i class="fa fa-plus-circle text-primary"></i> Ajukan Pertanyaan Baru
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.sandbox.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="subject2">Subjek / Topik <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                               id="subject2" name="subject" placeholder="Contoh: Cara input barang baru" required>
                        @error('subject')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="message2">Pertanyaan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message2" name="message" rows="5" 
                                  placeholder="Jelaskan pertanyaan Anda dengan detail..." required></textarea>
                        @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="priority2">Prioritas</label>
                        <select class="form-control" id="priority2" name="priority">
                            <option value="normal">Normal</option>
                            <option value="high">Penting</option>
                            <option value="low">Rendah</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-send"></i> Kirim Pertanyaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection


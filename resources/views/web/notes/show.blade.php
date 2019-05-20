@extends('layouts.app')
@section('title', ' - Notes【'.$note->title.'】')
@section('content')
        <div class="note_show">
            <div class="content_head">
                <a class="icon" href="/notes">
                    <img src="/img/top_note.png" alt="note">
                </a>
                <div class="text">
                    <a href="/notes">Notes</a>
                </div>
                <a class="link" href="/notes/search">
                    <img src="/img/note_search.png" alt="">
                </a>
                <a class="link" href="/notes/create">
                    <img src="/img/note_create.png" alt="">
                </a>
            </div>
            <div class="loading-wrapper" v-show="loading">
                <div class="loading"></div>
            </div>
            <show-note 
            :user="{{ auth()->user() }}"
            :note="{{ $note }}"
            :author="{{ $note->user }}"
            :photos="{{ $note->photos }}"
            :category="{{ $note->category }}"
            :countries="{{ $note->countries }}"
            :tags="{{ $note->tags }}"
            :is_fav="{{ auth()->user()->favNotes()->where('note_id', $note->id)->count() }}"
            :num_of_fav="{{ $note->favUsers()->count() }}"
            ></show-note>
        </div>
@endsection
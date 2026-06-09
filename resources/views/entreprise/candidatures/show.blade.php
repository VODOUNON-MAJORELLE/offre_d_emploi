@extends('layouts.entreprise')
@section('title', 'Détail candidature')
@section('page_title', 'Détail candidature')

@section('content')
<div style="text-align:center;padding:4rem;background:#fff;border-radius:14px;border:1px solid #e8ecf0">
    <p style="color:#94a3b8">Détail candidature à venir.</p>
    <a href="{{ route('entreprise.candidatures.index') }}"
       style="color:#6366f1;text-decoration:none">← Retour aux candidatures</a>
</div>
@endsection
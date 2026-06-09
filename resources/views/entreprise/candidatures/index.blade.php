@extends('layouts.entreprise')
@section('title', 'Candidatures')
@section('page_title', 'Candidatures')

@section('content')
<div style="text-align:center;padding:4rem;background:#fff;border-radius:14px;border:1px solid #e8ecf0">
    <div style="font-size:3rem;margin-bottom:1rem">📭</div>
    <h3 style="color:#1A2340;font-weight:600">Aucune candidature pour l'instant</h3>
    <p style="color:#94a3b8">Les candidatures apparaîtront ici quand des candidats postuleront à vos offres.</p>
    <a href="{{ route('entreprise.offres.index') }}"
       style="background:#6366f1;color:#fff;border-radius:10px;padding:0.65rem 1.5rem;text-decoration:none;font-weight:600;display:inline-block;margin-top:1rem">
        Voir mes offres
    </a>
</div>
@endsection
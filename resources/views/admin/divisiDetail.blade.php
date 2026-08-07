@extends('layoutsAdmin.master')
@php
    function fotoTeknisi($user) {
        if ($user->foto) {
            return asset('storage/' . $user->foto);
        }

        return "https://ui-avatars.com/api/?name=" .
                urlencode($user->nama) .
                "&background=E2001A&color=fff&size=128";
    }
@endphp
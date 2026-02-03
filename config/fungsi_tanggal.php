<?php
// Konvesi yyyy-mm-dd -> dd-mm-yyyy dan memberi nama bulan
function tgl_eng_to_ind($tgl)
{
    $tanggal = explode('-', $tgl);
    $kdbl = $tanggal[1];

    if ($kdbl == '01') {
        $nbln = 'Januari';
    } elseif ($kdbl == '02') {
        $nbln = 'Februari';
    } elseif ($kdbl == '03') {
        $nbln = 'Maret';
    } elseif ($kdbl == '04') {
        $nbln = 'April';
    } elseif ($kdbl == '05') {
        $nbln = 'Mei';
    } elseif ($kdbl == '06') {
        $nbln = 'Juni';
    } elseif ($kdbl == '07') {
        $nbln = 'Juli';
    } elseif ($kdbl == '08') {
        $nbln = 'Agustus';
    } elseif ($kdbl == '09') {
        $nbln = 'September';
    } elseif ($kdbl == '10') {
        $nbln = 'Oktober';
    } elseif ($kdbl == '11') {
        $nbln = 'November';
    } elseif ($kdbl == '12') {
        $nbln = 'Desember';
    } else {
        $nbln = '';
    }

    $tgl_ind = $tanggal[2] . ' ' . $nbln . ' ' . $tanggal[0];
    return $tgl_ind;
}
?>
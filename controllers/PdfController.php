<?php

class PdfController extends Controller
{

    public function pdf_seguro()
    {
        return $this->view('pdf/pdf_seguros');
    }

    public function pdf_facturaCompra()
    {
        return $this->view('pdf/pdf_facturaCompra');
    }

    public function pdf_facturaConsulta()
    {
        return $this->view('pdf/pdf_facturaConsulta');
    }

    public function pdf_facturaSeguro()
    {
        return $this->view("pdf/pdf_facturaSeguro");
    }

    public function pdf_facturaMedico()
    {
        return $this->view("pdf/pdf_facturaMedico");
    }

    public function pdf_consulta()
    {
        return $this->view("pdf/pdf_consulta");
    }

    public function pdf_insumosFaltantes()
    {
        return $this->view("pdf/pdf_insumosFaltantes");
    }

    public function pdf_historialMedico()
    {
        return $this->view("pdf/pdf_historialMedico");
    }

    public function pdf_citas()
    {
        return $this->view("pdf/pdf_cita");
    }

    public function pdf_consultasEmergencia()
    {
        return $this->view("pdf/pdf_consultasEmergencia");
    }

    public function pdf_cintillo(){
        return $this->view("pdf/pdf_cintillo");
    }
}

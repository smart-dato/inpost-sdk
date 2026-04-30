<?php

namespace Smartdato\InPost\Enums;

enum LabelFormat: string
{
    case PdfA4 = 'application/pdf;format=A4';
    case PdfA6 = 'application/pdf;format=A6';
    case Zpl203 = 'text/zpl;dpi=203';
    case Zpl300 = 'text/zpl;dpi=300';
}

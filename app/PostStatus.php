<?php

namespace App;

enum PostStatus: string
{
    case PROCESSADO = "processado";
    case EM_PROCESSAMENTO = "em processamento";
}

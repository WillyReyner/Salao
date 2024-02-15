<?php

namespace Database\Seeders;

use App\Models\TipoArquivo;
use Illuminate\Database\Seeder;

class DocumentosExigidosSeed extends Seeder
{
	public function run(): void
	{
		TipoArquivo::create([
			'nome' => 'Copia do RG',
			'orientacao' => 'Copia do RG& Copia do RG& Copia do RG&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '1',
		]);
		TipoArquivo::create([
			'nome' => 'Copia do CPF',
			'orientacao' => 'Copia do CPF& Copia do CPF& Copia do CPF&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '0',
		]);
		TipoArquivo::create([
			'nome' => 'Original e copia da carteira de trabalho (CTPS)',
			'orientacao' => 'Original e copia da carteira de trabalho (CTPS)& Original e copia da carteira de trabalho (CTPS)& Original e copia da carteira de trabalho (CTPS)&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '1',
		]);
		TipoArquivo::create([
			'nome' => 'Inscricao no PIS/Pasep',
			'orientacao' => 'Inscricao no PIS/Pasep& Inscricao no PIS/Pasep& Inscricao no PIS/Pasep&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '0',
		]);
		TipoArquivo::create([
			'nome' => 'Foto 3×4',
			'orientacao' => 'Foto 3×4& Foto 3×4& Foto 3×4&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '0',
		]);
		TipoArquivo::create([
			'nome' => 'Copia do titulo de eleitor',
			'orientacao' => 'Copia do titulo de eleitor& Copia do titulo de eleitor& Copia do titulo de eleitor&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '1',
		]);
		TipoArquivo::create([
			'nome' => 'Original e copia da carteira de habilitacao (CNH) (caso o cargo utilize veiculo, atentar para a categoria exigida)',
			'orientacao' => 'Original e copia da carteira de habilitacao (CNH) (caso o cargo utilize veiculo, atentar para a categoria exigida)& Original e copia da carteira de habilitacao (CNH) (caso o cargo utilize veiculo, atentar para a categoria exigida)& Original e copia da carteira de habilitacao (CNH) (caso o cargo utilize veiculo, atentar para a categoria exigida)&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '1',
		]);
		TipoArquivo::create([
			'nome' => 'Copia do comprovante de endereco',
			'orientacao' => 'Copia do comprovante de endereco& Copia do comprovante de endereco& Copia do comprovante de endereco&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '0',
		]);
		TipoArquivo::create([
			'nome' => 'Copia do comprovante de escolaridade',
			'orientacao' => 'Copia do comprovante de escolaridade& Copia do comprovante de escolaridade& Copia do comprovante de escolaridade&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '0',
		]);
		TipoArquivo::create([
			'nome' => 'Original e copia do registro profissional emitido pelo orgao da classe',
			'orientacao' => 'Original e copia do registro profissional emitido pelo orgao da classe& Original e copia do registro profissional emitido pelo orgao da classe& Original e copia do registro profissional emitido pelo orgao da classe&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '0',
		]);
		TipoArquivo::create([
			'nome' => 'Copia da certidao de nascimento (caso solteiro) ou certidao de casamento (caso casado)',
			'orientacao' => 'Copia da certidao de nascimento (caso solteiro) ou certidao de casamento (caso casado)& Copia da certidao de nascimento (caso solteiro) ou certidao de casamento (caso casado)& Copia da certidao de nascimento (caso solteiro) ou certidao de casamento (caso casado)&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '1',
		]);
		TipoArquivo::create([
			'nome' => 'Copia do certificado de reservista (para homens entre 18 e 45 anos)',
			'orientacao' => 'Copia do certificado de reservista (para homens entre 18 e 45 anos)& Copia do certificado de reservista (para homens entre 18 e 45 anos)& Copia do certificado de reservista (para homens entre 18 e 45 anos)&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '1',
		]);
		TipoArquivo::create([
			'nome' => 'Original do atestado de saúde ocupacional (obtido em uma clinica de exame admissional)',
			'orientacao' => 'Original do atestado de saúde ocupacional (obtido em uma clinica de exame admissional)& Original do atestado de três (obtido em uma clinica de exame admissional)& Original do atestado de três (obtido em uma clinica de exame admissional)&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '0',
		]);
		TipoArquivo::create([
			'nome' => 'Copia da certidao de nascimento de filhos de ate 21 anos',
			'orientacao' => 'Copia da certidao de nascimento de filhos de ate 21 anos& Copia da certidao de nascimento de filhos de ate 21 anos& Copia da certidao de nascimento de filhos de ate 21 anos&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '1',
		]);
		TipoArquivo::create([
			'nome' => 'Copia do cartao de vacina e comprovante de frequencia escolar para filhos de ate 7 anos',
			'orientacao' => 'Copia do cartao de vacina e comprovante de frequencia escolar para filhos de ate 7 anos& Copia do cartao de vacina e comprovante de frequencia escolar para filhos de ate 7 anos& Copia do cartao de vacina e comprovante de frequencia escolar para filhos de ate 7 anos&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '0',
		]);
		TipoArquivo::create([
			'nome' => 'Original e copia da carta de referencia',
			'orientacao' => 'Original e copia da carta de referencia& Original e copia da carta de referencia& Original e copia da carta de referencia&',
			'tipo_arquivo' => 'Arquivo',
			'tipo_versao' => '0',
		]);
	}
}

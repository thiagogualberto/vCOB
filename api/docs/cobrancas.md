# Cobranças

## Juros

Caso precise cobrar juros após atraso, é necessário informar a porcentagem e a quantidade de dias atrasados:

```json
{
    "juros": {
        "%": 0.2,
        "dias": 5
    }
}
```

## Multas

Caso precise cobrar multa após atraso, é necessário informar a porcentagem e a quantidade de dias atrasados:

```json
{
    "multa": {
        "%": 0.15,
        "dias": 5
    }
}
```

## Instruções

O sistema VCob possui 4 tipos de instruções para os boletos, para informar se há desconto de valor fixo, ou percentual

1. Valor fixo até a data informada
2. Percentual até a data informada
3. Desconto por dia corrido de antecipação
4. Desconto por dia útil de antecipação

Caso for usar algum tipo de instrução, é necessário incluir todos campos filhos, pois todos são obrigatórios.
Exemplos:

### 1. Valor fixo até a data informada
```json
{
    "instrucoes": {
        "tipo": 1,
        "valor": 25,
        "data_final": "2018-02-26"
    }
}
```

### 2. Percentual até a data informada
```json
{
    "instrucoes": {
        "tipo": 2,
        "%": 25,
        "data_final": "2018-02-26"
    }
}
```

### 3. Desconto por dia corrido de antecipação
```json
{
    "instrucoes": {
        "tipo": 3,
        "valor": 0.20
    }
}
```

### 4. Desconto por dia útil de antecipação
```json
{
    "instrucoes": {
        "tipo": 4,
        "valor": 0.20
    }
}
```
# MLTools App
[![Build Status](https://travis-ci.com/rafaelign/mltools-app.svg?token=FqRT3Psan5vzzZzcVTbL&branch=master)](https://travis-ci.com/rafaelign/mltools-app)

## Requisições JSON
### Exemplo de retorno
#### Sucesso

```js
{
    "status": "success",
    "data": {
        "lacksTOS": false,
        "invalidCredentials": false,
        "authToken":"4ee683baa2a3332c3c86026d"
    }
}
```

#### Falha

```js
{
    "status": "error",
    "message": "token is invalid",
    "data": "NameOfException"
}
```

## MailDocker

```
TXT
v=spf1 include:spf.ecentry.io ~all

TXT
ecentry._domainkey
v=DKIM1; g=*; k=rsa; p=MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBLTlS2DySFDRCsAqkUsIjAI7RvuRS6q5aTMyrdp9LogFjO7yTQKw/vw+bKrhHu1NuVWciRNp32m6E/imM5waqWL7w9xh4O8ap0jwORILrJvl/4NLLWXR/LuzIzmZ61nChq0vDOjdzCmBR6mALwzES4Ss2gPwldmTbtmVN14+0aQIDAQAB
```

<?php
return [
    //应用ID,您的APPID。
    'app_id' => "2016102400753755",

    //商户私钥
    'merchant_private_key' => "MIIEowIBAAKCAQEAp6PGnp/l/Rqcl78p6UcP+OP7sJLaCRinJY91yRija0tOX4zA/b4qzpHv4oo9pWyuUUl0KQpkdmn7A7jH3cJyPdjMtsRDSGQBTs0VQ2+kNADEHK34v4rbYW/5U56UqhWlfr2QSuieRJgu7PT1OAPpAd72v55vSGRFIK+GqtJBRwwqTUoO3+e7wHk8mpu3woE36ZtOwncghMYDRfM8s85QW5YXa8b8R+urIBiqcLfw+b9GsschllnpYQ6QJJBu3uGPgcsueAyv/IVx1oezR0zIh23RHljGbujW59fg4kXn89ZgPe/d2bnzjhDZoebxr5SRYbA+t/HCfHTqzZcHglPXBQIDAQABAoIBAHXp053lWG7kFfsCgidMTabCLVmwoV4+kerwcmfFRcUFThYVOfYAmbl8mt+cXuoJfL8+TE9FuQ41U1L12NdZmuN3p95yQ+UaOnVD+U3arAPL+iU2FT4dHFv318aCR40u9p4kFecqoZAb/v26+vSwg2dGfgagGSQxKxJng/CJPVMLzrlg2KKIwEs4Lh0AcBP0oVdBGg9NrQK7UKtE1Mol85Oj6u1DfS5STlondhSJqnt1qMWgc52R8VaflCK84H9cnhoYwRpwYWvSqQWU0by8TApKNqvREjz99z+OLRQFImTGOOhpQkPNDiMAWpoZDWM2VMoHvUcREwiVgmthE+FI8iECgYEA2Z027WSPiALZg03PcvQRRkkgcVpQus1skjuxeN0aY+3IKM6iuKzH0sOI57CyekiCZAC61ACDZUmxHDgbdmw1kwsmzeqWhuGqJvwCIgnCtFqiYy+L65xTuBij1SDl1+v956sgfN3dZmkJOWa8uTAqZvGlYe0ydUyxjknHdFnC6o0CgYEAxTXfSH4676Ni8zBRBPSeh9PheD9Zj17stQz1a61H2SkX/CWPrXOL3qVE5IKF8aQGdyZ3CNl0UFcuTKF+4GwRbIjoi5ub9WDf8QkPnsVtjTuMhP8RX6aon3ha7wD3nv69bsd01hWx1YjHdn/izMZeLP2CcFmIEkKdQNH2a5DEfFkCgYACr68i5Q/khOx8c3RxHdQswvBUleHTPH/vmi8Jp+kQfLnwzwQxNWjOED3bZlH9snFxnJSx00PL90npaEPmhVVv+D5FYnTzO0vnaUr5cpdltIy2nrqicO6TojI7iklsDey3dGRVRkPaZMeJXtxLiO2tEaSR/eSWkBjNAdoldIo0bQKBgQDEjSrbL6RBzxAB3TgCvmN6cLyZgloawLsev6mjBfNEBub20eDfOPhAkWuWbFhfO+GNw3KECWcZ46orihHQTyUWjWVoL1FDQKgxrZw52/+R8bXdn/KK6KnLNsM6zjX961qWHIjgDoNNlaNnAZLkERkvsgLdQv6RZH8iaaE2F/UdEQKBgBAdP1zGwAFkW4a845qGAMm+iXI7xd8MSIldH69D1HByJAHF6IC5Cqbkqm6wTWquFEAqNbHPaOEBbKsMvCJYVMHTFVuEbn7yzVjxF8FrTNo69saNGlMrpTTp1aYB0W6Ec7qNg2jZpNdsF/Nyxqw83sdAGwMpKMaN2SFhDxEuxB51",

    //异步通知地址
    'notify_url' => "http://外网可访问网关地址/alipay.trade.page.pay-PHP-UTF-8/notify_url.php",

    //同步跳转
    'return_url' => "http://local.shop1.com/order/success",

    //编码格式
    'charset' => "UTF-8",

    //签名方式
    'sign_type'=>"RSA2",

    //支付宝网关
    'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

    //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
    'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB",

        ];
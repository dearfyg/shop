<?php
return [
    //应用ID,您的APPID。
    'app_id' => "2016102400753755",

    //商户私钥
    'merchant_private_key' =>"MIIEogIBAAKCAQEAo+LgWwQkVYDdcgkHZTj9rID6zw2eqcC4GDB6OGOiroIdjQKC5/w3XQ2zqzcG2ylm25OEv5Jjz0rMr3UyKnayLxACoevKRlYWybc0FwLyVGe63FkO8SIQAS2vohz3yx3Boe322GxB5XAeBncwL/yeRK5ylg7+MgySnf2ilGPYGQ+92i5/nRa02gAQ7ihhdrvu3vBxGpKFymYSGu16GfT2Pg9zW3rjG4uleOfd1Nj4Nbqo4jVS4l/0npsJp7cwjDl3g8tSyvASLCY9DH6RXZ+u8rVWDPlPpkiAQaRXGqEOaysd2I2p/c7Tqr8/TL2Mbc4VifGnmiq7EWWFePDVzswLWwIDAQABAoIBAB45GtLuIp06FJyRGbILHo0PhDFm+5mmlsyvM/ruNPQlvrlgey+5DaS1gCrVDQihy/w2akbCAnIaA0FgRY4bMaUIONQPnc/21GECzjJoMrRqJMW6Ds1dUMJG4Jru6Kumoyzvq5Qh8s0TLhZXKKXQ2ocj/LG7thkYxHkqay8ecp28Q+Bfg9dkLXofsgdRG8XYKxcH7XR1rnqmG6gaLNsGW7E62+JDCLeAHO4l2noolZKA0Sk0O+8nOYUdXDBK2cDDPFF4Sj/6FNtEf63hjGvAqge8KsivpGoY873zwTXuF2/9y/b8cvsdltUTmvWumqRJ6/N13pTKAJdtOFj82hsiokECgYEA0RwPLwV2Uu49a98QH8hyR9txotnGfDNX1o77YYz9Nsyxx8vYm+ED5xZOtUMyNvdF0rG4yldJz2B1dNBnHvWUUxiEvPssrIPEdtZ5pX4AxVfGfknJcyruBGt/GyT4lSvQkmmXNaVIs8DnZtdn3dGZKT0N4IU5bnI1lmsTBXlvxvECgYEAyKLEx8hiz4H/TjF4L5JUTt+B7iTwvxEBpPEHC5rAnkgCA+gcY+Wo0fOMTylUvuQWdXldHkRxVsIL921iEnGkJR/QcMfVmHcAEKKHAw+YWdEGxFeTZCJHAAhQYKcW4ppH8r2JlQRWIN+qr4z7hs/2Y9ysfjQRK2EAk6FZZ/N8bwsCgYA+owgNTraNyt1NJakfzBwnWB1m6ZLh+0Mxeuzj4Kasto3+ShpdPv67RtxWwYUWH+WjYib3PURXwQ4N6qspA+jlJzADp71PA71i14Xiw6aZdlx30cRtIgvf+Q8+40ku7cvxP33SzOrFJWBrVtS/Bhy51JcGjQGSCtXwc6xj9Gc+EQKBgDaN66vXFOcPlfgRA3kL9NitdYrniH6rhSLwVtYU8iMXuVSOnImdPNY5vwEXX++33VN7+JHuUlMg2Fgi6fPR6qwdhnPkInQeh2n+h2+Rof9qEsj4dx9XIq8jk5d0V4iuIroiR3K5hyHRL3wkfZAepARrUIvQZIrDCYEa8lCNqFwZAoGAH2Oxrt51O8GVm8z3yhy9AyZo9PhL3WWQ5jdwsHdkyRb1iKJnBpl25m02Uvn1JGNhLbemSt16D4Id0QQlyG2Uta+5VoD2R1m+TN5etXthzIFgWwk3dFLbWkkMopYGChgD1riqfUttUik8qDkAfZY7fq1BZeNCv8ThDEBQtoMdC9o=",

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
    'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEArwhsFBkdXIAeufyJFQQCI45eI2vjmXUHfzy4u097faGEGeTFlSwo1R/nuwLNj3wuIQ7a+8rjLrzP1GXHL67sVRPWTZzUBoV1g0mEX7tOFMFNEyb/hzjvwPpz6ESelIhwDGzen9KkKhR3kTF+aTw0fJtJj6d1N2uetYYcjImINsgM5AYqlAseawuM1l5+NjhwiA+Py9VQO+xEV/hm/70nNNE7bFnquRDL6I7hxhxAXi5/QVO64XnX4lupvIC0t9+aPPrZfNNd8a3n/Nx476Pzgee7cYjDN8DDwJHX5ZcajUFfsrJ4gdVFLh0oqZrZ+6mHhqHHcMglXNG4W1N6bGZzDwIDAQAB",
        ];
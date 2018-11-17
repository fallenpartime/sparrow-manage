Mock.mock(
    'http://school', {
        code: 1,
        result: [
            {
                schoolName: '黄海学院1',
                schoolAddress: '山东省青岛市黄海学院',
                schoolPropery: '公办',
                schoolTel: 15194275203
            },
            {
                schoolName: '黄海学院1',
                schoolAddress: '山东省青岛市黄海学院',
                schoolPropery: '公办',
                schoolTel: 15194275203
            },
            {
                schoolName: '黄海学院2',
                schoolAddress: '山东省青岛市黄海学院',
                schoolPropery: '公办',
                schoolTel: 15194275203
            }
        ]
    }
);
Mock.mock(
    'http://list', {
        "code":200,
        "msg":"",
        "data": 
        { 
            "code":"VqVJsMqm",
            'pageNo': 1,
            'pageCount': '4', 
            "list":[
                {"title":"aaa","desc":"aaa","image":"\/storage\/20181024\/6LYbZZWdS5DRCIKONhvvaYpaPhhr7ZZ5OvR6yxb8.jpeg",
            "link":"http:\/\/120.224.161.3:8090\/front\/article\/news\/pYXPcpYR"}
            ]
        },"url":""}
);
Mock.mock(
    'http://vote', {
        "code":200,
        "msg":"",
        "data": 
        { 
            "code":"VqVJsMqm",
            'pageNo': 1,
            'pageCount': '4', 
            "list":[
                {"title":"aaa","desc":"aaa","image":"\/storage\/20181024\/6LYbZZWdS5DRCIKONhvvaYpaPhhr7ZZ5OvR6yxb8.jpeg",
            "link":"http:\/\/120.224.161.3:8090\/front\/article\/news\/pYXPcpYR"}
            ]
        },"url":""}
);
Mock.mock(
    'http://map', { 
        "code": 1,
        "result": {
            "name": "abb",
            "address": "诺德广场",
            "telent": "3333333333",
            "district": "这里是我毕业后第一次工作的时候",
            "lng": 120.38808621487111,
            "lat": 36.09813563744705,
            "property": "公立"
            }
    }
);
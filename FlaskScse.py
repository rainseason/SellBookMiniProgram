# coding=utf-8
import requests
from pyquery import PyQuery as pq
from flask import Flask, request, jsonify
import json
import re

# 由于涉及学校教务系统信息，这里url脱敏处理
base_url = "http://xxx.sise.com.cn:1234/sise/login.jsp"
check_url = "http://xxx.sise.com.cn:1234/sise/login_check_login.jsp"
login_url = "http://xxx.sise.com.cn:1234/sise/module/student_states/student_select_class/main.jsp"
stuinfo_url = "http://xxx.sise.com.cn:1234/SISEWeb/pub/course/courseViewAction.do?method=doMain&studentid="

keys = []
values = []

session = requests.session()#定义全局session


def get_Formdata(username,password):
    response = requests.get(base_url)
    # print(response.text)
    doc = pq(response.text)
    random = doc("#random").attr("value")
    name = doc(
        'body > div > form > input[type="hidden"]:nth-child(1)').attr("name")
    value = doc(
        'body > div > form > input[type="hidden"]:nth-child(1)').attr("value")
    # print(random,name,value)
    data = {
        name: value,
        random: random,
        "username": username,
        "password": password
    }
    return data


def login(data):
    response = session.post(check_url, data=data)
    if response.status_code == 200:
        response = session.get(login_url)
        # print(response.text)
        return response.text


def parse_stuid(content):
    pattern = re.compile("studentid=(.*?)\'")
    result = re.search(pattern, content)
    # print(result.groups(1)[0])
    if result:
        stuid = result.groups(1)[0]
        return stuid
    return False


def get_stuinfo(stuid):
    info_url = stuinfo_url + stuid
    # print(info_url)
    response = session.get(info_url)
    global session
    session = requests.session()#清除全局session的值,防止下次获取
    if response.status_code == 200:
        result = parse_stuinfo(response.text)
        return result


def parse_stuinfo(html):
    # print(html)
    doc = pq(html)
    stuinfo = doc("#form1 table tr td table tr td").items()
    i = 0
    for item in stuinfo:
        if item.text() != '':  # 判断值是否为空
            if i % 2 == 0:
                str = unicode("：",'utf-8')#解决中文编码
                keys.append(item.text().strip(str))
            else:
                values.append(item.text())
        i += 1
    result = dict(zip(keys, values))  # 把两个列表转化为一个字典
    # print(result)
    return result


def main(username,password):
    data = get_Formdata(username,password)
    if data:
        html = login(data)
        if html:
            stuid = parse_stuid(html)
            if stuid:
                result = get_stuinfo(stuid)
                return result
            else:
                return False



# http://127.0.0.1:8000/?stuId=164&stuPwd=xx
app = Flask(__name__)


@app.route('/', methods=['GET'])
def index():
    username = request.args.get('stuId').encode('utf-8')
    password = request.args.get('stuPwd').encode('utf-8')
    res = main(username,password)  # 调用主函数
    if res:
        print json.dumps(res,encoding='UTF-8',ensure_ascii=False)#输出结果，解决中文乱码
        return jsonify(res)  # 返回json数据
    else:
        return '请求失败！'


if __name__ == '__main__':
    app.run(host='127.0.0.1', port=8000, debug=False)

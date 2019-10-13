# SellBookMiniProgram

#### 介绍
项目主要实现功能：学生学号登录(python爬虫模拟登录，在教务系统抓取用户基本信息)、微信授权登录获取用户openid、使用令牌方式实现用户三天免登录、书籍管理、购物车管理、订单管理、商品分类搜索。


#### 软件架构

前端：微信小程序

后端：Python、ThinkPHP5

数据库E-R图（这里只画出主要的实体和属性）：

<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/er.png">
</div>

#### 小程序端页面展示

**1. 微信授权界面**
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/login.png" width="320px" height="550px">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/login-access.png" width="320px" height="550px">
</div>

**2. 用户拒绝授权和学号登录**

<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/login-deny.png" width="320px" height="550px">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/login-stuno.png" width="320px" height="550px">
</div>

**3. 授权成功后，获取openid和爬取用户信息存MySQL**
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/login-admindb.png">
</div>

> 微信小程序的授权登录功能，拿到了用户的openid并存到数据库，返回用户3rd_session令牌
当用户用学号/密码登录成功后把3rd_session存到本地缓存中,把用户学号，密码，等个人信息存到数据库，当用户第二次打开时，首先验证用户3rd_session是否有效，有效->进入主页，无效->重新授权登录，校验数据库中的学号密码。3rd_session有效期是3天（实现3天免登陆）

 **4. 用户输入学号密码，发送到python flask接口，执行爬虫**
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/python-flask.png">
</div>

 **5. 小程序首页，请求加载json数据功能实现**
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/show-all-book-json.png">
</div>

 **6. 小程序首页和商品分类功能实现**
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/book-index.png" width="320px" height="550px">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/book-category.png" width="320px" height="550px">
</div>

 **7. 书籍发布功能实现**
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/add-book-info.png" width="320px" height="550px">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/publish-book.png" width="320px" height="550px">
</div>

 **8. 书籍发布功能实现**
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/shop-car.png" width="320px" height="550px">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/persional.png" width="320px" height="550px">
</div>

#### 使用说明

> 本项目是本人在选修微信小程序课程后做的第一个小项目，**已经不再维护**，而且腾讯云服务器已经不再租用了。所以，项目服务端已经跑不起来，只能用作展示。小程序端勉强能跑起来，但获取不到后台数据，想要学习界面制作、网络爬虫模拟登录的可以下载参考。

#### 小程序登录授权、商品发布、多图片上传主要代码
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/login-code.png">
</div>
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/login-code1.png">
</div>
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/3rd-session.png">
</div>

```javascript
// pages/puslish/publish.js
import {Publish} from './publish-model.js';
var publish = new Publish();
import { Config } from '../../utils/config.js';
var dominate = Config.dominate;

Page({
  /**
   * 页面的初始数据
   */
  data: {
    bookType: [],
    hx_index:0,
    goods_isbn:'',
    isHidden: true,
    Hidden: false,
    imagesUrl: [],
    image_url:[]
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    this.loadData();
    var str = wx.getStorageSync('token');
    this.setData({
      token:str.token
    })
  },
  PickerTypeChange: function(e) {
    var index = parseInt(e.detail.value);
    console.log('图书类型：', this.data.bookType[index].type_name)
    this.setData({
      hx_index: index
    })
  },
  canIsbnCode: function(e) {
    var that = this;
    wx.scanCode({
      onlyFromCamera: true,
      success: function(res) {
        // console.log(res);
        that.setData({
          goods_isbn:res.result
        })
      },
      fail:function(err){
        console.log('无效的ISBN')
      }
    })
  },
  //图片选择事件处理
  uploadImg: function() {
    var that = this;
    wx.chooseImage({
      count: 1,
      sizeType: ['original', 'compressed'],
      sourceType: ['album', 'camera'],
      success: function(res) {
        // tempFilePath可以作为img标签的src属性显示图片
        const tempFilePaths = res.tempFilePaths
        // console.log(res);
        var list = that.data.imagesUrl;
        list.push({
          url: tempFilePaths
        }); //把选择到的图片路径添加到数组
        if (list.length >= 4) {
          that.setData({
            Hidden: true
          })
        }
        that.setData({
          isHidden: false,
          imagesUrl: list //把数组重新赋值遍历渲染
        })
      },
    })
  },
  // 删除图片
  delImg:function(e){
    var that = this;
    var imageArray = that.data.imagesUrl;
    var index = e.target.dataset.index;
    // console.log(e)
    wx.showModal({
      title: '提示',
      content: '你要删除此图片吗？',
      success:function(res){
        // console.log(res)
        if(res.confirm){
          imageArray.splice(index,1)//删除数组中图片
          that.setData({
            Hidden:false,
            imagesUrl:imageArray
          })
        }else{
          console.log("没删除图片")
        }
      }
    })
  },
  //执行提交操作：上传图片，提交数据
  publishSubmit:function(form){
    // console.log(res)
    var that = this;
    var imageArray = that.data.imagesUrl;//本地临时url数组
    if (imageArray.length != 0) {
      //上传图片
      that.doUploadImage(imageArray,(res)=>{
        // console.log(that.data.image_url)
        // //提交表单
        form.detail.value['type_id'] = that.data.hx_index + 2;
        form.detail.value['images'] = JSON.stringify(that.data.image_url);//把数组转换成字符串
        // console.log(form.detail.value)
        console.log(form)
        publish.submitForm(form.detail.value, (res) => {
          console.log(res)
          //上传完毕，清空数据
          that.setData({
            imagesUrl: []
          })
          if(res.data.code==200){
            wx.showToast({
              title: '发布成功',
              icon: 'success',
              duration: 2000
            })
            wx.switchTab({
              url: '/pages/classify/classify',
            })
          }else(
            wx.showModal({
              title: '提示',
              content: '上传失败！',
              success(res) {
                if (res.confirm) {
                  console.log('用户点击确定')
                } else if (res.cancel) {
                  console.log('用户点击取消')
                }
              }
            })
          )
        })
      });
    } else {
      console.log("你还没选择图片！")
    }
  },
  doUploadImage: function (imageArray,callBack){
    var that = this;
    var flag = 0;
    //图片上传
    for (var i = 0; i < imageArray.length; i++) {
      wx.uploadFile({
        // url: 'http://test.xgguo.com/api/v1/upload/wxUpload',//本地调试
        url: 'http://pk.xgguo.win/api/v1/upload/wxUpload',//腾讯云
        filePath: imageArray[i]['url'][0],
        name: 'file',
        success(res) {
          console.log(res)
          var arr_res = JSON.parse(res.data);
          console.log("上传成功！");
          var str = arr_res.url;
          var url = dominate + "uploads/index/images/" + str.replace("\\", "/");
          that.data.image_url.push({
            image_url: url
          })
          flag++;
          // console.log(that.data.image_url)
          if(flag==imageArray.length){
            typeof callBack == "function" && callBack(res);
          }
        },
        fail(err) {
          console.log(err, "上传失败！")
        }
      })
    }
  },
  // 加载书籍类型
  loadData:function(res){
    var that = this;
    var data = publish.getBookList((res)=>{
      // console.log(res)
      res.data.splice(0,1);//删除第一条记录
      that.setData({
        bookType: res.data
      })
      // console.log(that.data.bookType)
    })
  },

```

#### 技术交流与分享

1. 关注我CSDN博客：[https://blog.csdn.net/weixin_41835653](https://blog.csdn.net/weixin_41835653)
2. 我的码云：[https://gitee.com/xgguo2](https://gitee.com/xgguo2)
3. 我的微信公众号：
<div style="display:bolck;" align = "center">
<img src="https://gitee.com/xgguo2/SellBookMiniProgram/raw/master/README-IMG/qrcode_for_gh_85b4e890d98b_258.png" width="320px" height="320px">
</div>
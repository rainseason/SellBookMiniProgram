// pages/start/start.js
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },
  getUserInfo: function(e) {
    // console.log(e.detail.userInfo)
    if (e.detail.userInfo) { //用户按了允许授权
      wx.login({ //调用login获取code
        success: function(res) {
          // console.log(res)
          var code = res.code;
          wx.getUserInfo({ //获取用户信息
            success: function(res) {
              console.log(res)
              // var userNick = res.userInfo.userNick;
              // var avataUrl = res.userInfo.avataUrl;
              // var gender = res.userInfo.gender;
              //以下信息提交给第三方服务器解密
              var iv = res.iv; //加密算法的初始向量
              var rawData = res.rawData; //不包括敏感信息的原始数据字符串，用于计算签名
              var encryptedData = res.encryptedData; //包括敏感数据在内的完整用户信息的加密数据
              var signature = res.signature; //使用 sha1( rawData + sessionkey ) 得到字符串，用于校验用户信息
              if (code) { //把code和解密信息提交第三方服务器
                wx.request({
                  url: 'http://test.xgguo.com/index/index/wxLogin',
                  data: {
                    code: code,
                    iv: iv,
                    rawData: rawData,
                    encryptedData: encryptedData,
                    signature: signature
                  },
                  header: {
                    'content-type': 'application/json'
                  },
                  success: function(res) {
                    console.log(res.data)
                    // wx.setStorageSync('name', res.data.name); //把名字存到缓存
                    console.log('授权登录成功！');
                    // wx.navigateTo({
                    //   url: '/pages/login/login',
                    // })
                  }
                })
              } else {
                console.log('调用login获取code失败！');
              }
            }
          })
        }
      })
    } else { //用户点击拒绝授权按钮
      wx.showModal({
        title: '警告',
        content: '拒绝授权，将无法使用小程序，请授权之后再进入!',
        showCancel: false,
        confirmText: '返回授权',
        success: function(res) {
          if (res.confirm) {
            console.log('用户点了返回授权');
          }
        }
      })
    }
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    app.checkUserLogin(); //调用检查登录状态
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function() {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function() {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function() {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function() {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function() {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function() {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function() {

  }
})
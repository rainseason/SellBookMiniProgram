//app.js
App({

  /**
   * 当小程序初始化完成时，会触发 onLaunch（全局只触发一次）
   */
  onLaunch: function() {
    this.checkUserLogin();
  },
  //检查登录状态
  checkUserLogin: function() {
    var that = this;
    wx.getSetting({ //判断是否授权
      success: function(res) { //授权成功
        // console.log(res)
        if (res.authSetting['scope.userInfo']) {
          wx.getUserInfo({
            success: function(res) {
              // console.log(res)//用户信息
              // console.log(that.checkSessionId())
              //判断是否登录过
              if (that.checkSessionId()) { //授权成功并登录过，跳转首页
                wx.switchTab({
                  url: '/pages/index/index',
                })
              } else { //授权成功，未登录，跳转登录
                wx.navigateTo({
                  url: '/pages/login/login',
                })
              }
            }
          })
        }
      }
    })
  },
  checkSessionId: function() {
    wx.setStorageSync('sessionId', 'xgguo');
    var sessionId = wx.getStorageSync('sessionId');
    //请求sessionId
    // console.log(sessionId)
    if (sessionId != '') {
      return true;
    } else {
      return false;
    }
  },

  /**
   * 当小程序启动，或从后台进入前台显示，会触发 onShow
   */
  onShow: function(options) {

  },

  /**
   * 当小程序从前台进入后台，会触发 onHide
   */
  onHide: function() {

  },

  /**
   * 当小程序发生脚本错误，或者 api 调用失败时，会触发 onError 并带上错误信息
   */
  onError: function(msg) {

  }
})
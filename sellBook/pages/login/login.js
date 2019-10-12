// pages/login/login.js
Page({

  /**
   * 页面的初始数据
   */
  data: {
    nav_height: 0.11,
    nav_height_str: "11%",
    bg_height: "89%"
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    var that = this;
    wx.getSystemInfo({
      success: function(res) {
        var mode = res.model;
        console.log(mode)
        var nav_height = that.data.nav_height;
        if (mode == "iPhone X" || mode == "iPhone 5") {
          nav_height = 0.12;
        }
        var bg_height = 1 - nav_height;
        bg_height = bg_height * 100 + "%";
        var nav_height_str = nav_height * 100 + "%";
        that.setData({
          bg_height: bg_height,
          nav_height_str: nav_height_str
        })
      },
      fail: function() {
        // 失败操作
      }
    })
  },
  login_submit: function(res) {
    console.log(res)
    wx.request({
      url: 'http://blog.xgguo.win/index/index/myscse',
      data: {
        stuId: res.detail.value.username,
        stuPwd: res.detail.value.pwd
      },
      method: 'POST',
      success: function(e) {
        console.log(e)
        if (e.data.code == '1') {
          console.log("登录成功！")
          wx.showToast({
            title: '登录成功',
            icon: 'success',
            duration: 2000
          })
          // 跳转
          wx.switchTab({
            url: '/pages/index/index',
            success: function(res) {
              console.log('跳转成功！')
            }
          })
        } else {
          console.log("登录失败！")
          wx.showToast({
            title: '账号或密码错误!',
            icon: 'loading',
            duration: 2000
          })
        }
      },
      fail: function(error) {
        console.log(error)
      }
    })
  }
})
import React, { Component } from 'react';
import AppBar from 'material-ui/AppBar';
import Bottom from './Bottom';
import IconMenu from 'material-ui/IconMenu';
import MenuItem from 'material-ui/MenuItem';
import IconButton from 'material-ui/IconButton';
import MoreVertIcon from 'material-ui/svg-icons/navigation/more-vert';
import ReactCssTransitionGrop from 'react-addons-css-transition-group';
import 'styles/main.css';
import 'styles/animate.css';

export default class Main extends Component {
    constructor(props){
        super(props);
        this.state = {
            isRightMenuShow: false
        }
    }

    render(){
        return (
            <ReactCssTransitionGrop
                transitionName="fadeIn"
                transitionEnterTimeout={500}
                transitionLeaveTimeout={300}
                transitionAppearTimeout={500}
                transitionAppear
                component="div"
            >
                <AppBar
                    title="看 看 看 看"
                    titleStyle={{textAlign:'center',fontSize:'1.5rem'}}
                    iconStyleLeft={{display:'none'}}
                    iconElementRight={<VertMenu history={this.props.history} />}
                />
                <div className="mainContent">
                    <div className="lunbo" style={{background:'url(http://pic.58pic.com/58pic/13/85/85/73T58PIC9aj_1024.jpg)'}} />
                    <nav className="nav">
                        <ul>
                            <li><i className="dot" /> <span className="type">玄幻</span></li>
                            <li><i className="dot" /> <span className="type">校园</span></li>
                            <li><i className="dot" /> <span className="type">系统</span></li>
                            <li><i className="dot" /> <span className="type">都市</span></li>
                            <li><i className="dot" /> <span className="type">书库</span></li>
                        </ul>
                    </nav>
                    <div className="mainRecommend">
                        <span>编辑推荐</span>
                        <a><span><i className="house iconfont icon-icon2" />排行榜</span> <i className="right">&gt;</i></a>
                    </div>
                    <div className="recommendListContent">
                        <ul>
                            <BookListItemMain item={{ imgUrl:'http://img.17k.com/images/bookcover/default_cover1.jpg',
                                    hTitle:"Hello World", sortIntro: "Hello World",
                                    author:'fydor',
                                    word:'17.3万'
                                }}
                            />
                        </ul>
                    </div>
                    <div className="mainRecommend" style={{borderTop:'.5rem solid var(--gray-lighter)'}}>
                        <span>我的收藏</span>
                        <a><span><i className="house iconfont icon-xiaohua" />收藏记录</span> <i className="right">&gt;</i></a>
                    </div>
                    <div className="myLike">
                        <ul>
                            <li className="recommendList">
                                <div className="liLeft"><img src="http://image.cmfu.com/books/3330580/3330580.jpg" alt="" /></div>
                                <div className="liRight">
                                    <h3>道界天下</h3>
                                    <div className="liBottom justifyStart">
                                        <div className="mySubTitle">第二章</div>
                                        <span className="mySubContent">神秘村落中走出的神惧</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div className="footer">
                    <Bottom history={this.props.history} />
                </div>
            </ReactCssTransitionGrop>
        )
    }
}


/*header 右侧的菜单组件*/
/* eslint-disable */
const VertMenu = ({history}) => (
    <div>
        <IconMenu
            iconButtonElement={
                <IconButton> <MoreVertIcon /> </IconButton>
            }
            targetOrigin={{horizontal: 'right', vertical: 'top'}}
            anchorOrigin={{horizontal: 'right', vertical: 'top'}}
        >
            <MenuItem primaryText="About Author" onTouchTap={()=> history.push('/about')} />
        </IconMenu>
    </div>

)
VertMenu.muiName = 'IconMenu';


/*搜索结果列表*/
class BookListItemMain extends Component {
    render() {
        const { item } = this.props;
        const { imgUrl, hTitle, sortIntro, author, word } = item;
        return (
            <li className="recommendList">
                <div className="liLeft">
                    <img src={imgUrl} alt="" />
                </div>
                <div className="liRight">
                    <h3>{hTitle}</h3>
                    <p>
                        {sortIntro}
                    </p>
                    <div className="liBottom">
                        <span>{author}</span>
                        <span>{word}</span>
                    </div>
                </div>
            </li>
        )
    }
}

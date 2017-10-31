<{include "head.tpl"}>
  <table border="1" align="center" width="800">
    <{loop $users $user}>
      <tr>
        <{loop $user $u}>
          <{if $u == "meizi"}>
            <td bgcolor="green">
          <{elseif $u == "admin"}>
            <td bgcolor="red">
          <{else}>
            <td>
          <{/if}>
            <{$u}></td>
        <{/loop}>
      </tr>
    <{/loop}>
  </table>
    <h1><{$title}></h1>
    <div><{$content}></div>
<{include "foot.tpl"}>